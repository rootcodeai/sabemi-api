# Arquitetura de Domínio - Padrão ClientWallet

Este documento descreve a arquitetura padrão e deve ser seguido por IAs e desenvolvedores ao criar ou refatorar outros domínios no sistema, garantindo consistência, modularidade e escalabilidade.

## 1. Visão Geral e Estrutura de Diretórios

O sistema utiliza uma arquitetura orientada ao domínio (DDD - Domain Driven Design) simplificada dentro do Laravel. Cada "módulo" de negócio reside em `app/Domain/{NomeDoDominio}`.

A estrutura de diretórios do `NomeDoDominio` é a seguinte:

```
app/Domain/NomeDoDominio/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       └── NomeDoDominioController.php
│   └── Requests/
│       └── (FormRequests aqui)
├── Models/
│   ├── NomeDoDominio.php
│   └── NomeDoDominioTransaction.php
├── Observers/
│   ├── NomeDoDominioObserver.php
│   └── NomeDoDominioTransactionObserver.php
├── Providers/
│   ├── NomeDoDominioServiceProvider.php       <-- Provider Principal do Domínio
│   ├── NomeDoDominioEventServiceProvider.php  <-- Registro de Eventos/Observers
│   └── RepositoryServiceProvider.php         <-- Bindings de Repositórios
├── Repositories/
│   ├── Contracts/
│   │   ├── NomeDoDominioRepositoryInterface.php
│   │   └── NomeDoDominioTransactionRepositoryInterface.php
│   ├── Eloquent/
│   │   ├── EloquentNomeDoDominioRepository.php
│   │   └── EloquentNomeDoDominioTransactionRepository.php
│   └── Caching/
│       ├── CachingNomeDoDominioRepository.php
│       └── CachingNomeDoDominioTransactionRepository.php
└── Services/
    └── NomeDoDominioService.php
```

## 2. Service Providers (Modularização)

A chave para a modularidade é o uso de Service Providers específicos do domínio.

### 2.1. NomeDoDominioServiceProvider (Principal)
Este provider é o ponto de entrada do domínio. Ele deve ser registrado no `App\Providers\AppServiceProvider`.
Ele é responsável por registrar os outros providers do domínio.

```php
// app/Domain/NomeDoDominio/Providers/NomeDoDominioServiceProvider.php
namespace App\Domain\NomeDoDominio\Providers;

use Illuminate\Support\ServiceProvider;

class NomeDoDominioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registra bindings de repositório e eventos/observers específicos deste domínio
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(NomeDoDominioEventServiceProvider::class);
    }
}
```

### 2.2. RepositoryServiceProvider (Bindings)
Responsável por ligar as Interfaces às Implementações. Aqui definimos a estratégia de cache (Decorators).

```php
// app/Domain/NomeDoDominio/Providers/RepositoryServiceProvider.php
namespace App\Domain\NomeDoDominio\Providers;

use Illuminate\Support\ServiceProvider;
// Interfaces
use App\Domain\NomeDoDominio\Repositories\Contracts\NomeDoDominioRepositoryInterface;
// Implementações
use App\Domain\NomeDoDominio\Repositories\Eloquent\EloquentNomeDoDominioRepository;
use App\Domain\NomeDoDominio\Repositories\Caching\CachingNomeDoDominioRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Exemplo de Binding com Decorator de Cache
        $this->app->bind(NomeDoDominioRepositoryInterface::class, function ($app) {
            // Instancia a implementação Eloquent
            $repository = $app->make(EloquentNomeDoDominioRepository::class);
            
            // Retorna a implementação de Cache envolvendo a Eloquent (Decorator Pattern)
            // Agora injetando também o Model para acesso às tags de cache
            return new CachingNomeDoDominioRepository(
                $repository, 
                $app['cache.store'],
                $app->make(NomeDoDominio::class)
            );
        });
    }
}
```


### 2.3. NomeDoDominioEventServiceProvider (Observers)
Responsável por registrar Observers e Listeners do domínio. Isso evita poluir o `EventServiceProvider` global.

```php
// app/Domain/NomeDoDominio/Providers/NomeDoDominioEventServiceProvider.php
namespace App\Domain\NomeDoDominio\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Domain\NomeDoDominio\Models\NomeDoDominio;
use App\Domain\NomeDoDominio\Observers\NomeDoDominioObserver;

class NomeDoDominioEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
        
        // Registrar Observers
        NomeDoDominio::observe(NomeDoDominioObserver::class);
    }
}
```

## 3. Camada de Repositório e Cache

O padrão de repositório utiliza **três** componentes principais para cada entidade: Interface, Eloquent Implementation e Caching Implementation (Decorator).

### 3.1. Interface
Define o contrato.

```php
interface NomeDoDominioRepositoryInterface
{
    public function findByClientId(int $clientId);
    // ...
}
```

### 3.2. Implementação Eloquent
Acesso direto ao banco de dados. **Deve ser `final` e usar `declare(strict_types=1);`**.

```php
declare(strict_types=1);

namespace App\Domain\NomeDoDominio\Repositories\Eloquent;

use App\Domain\NomeDoDominio\Repositories\Contracts\NomeDoDominioRepositoryInterface;
use App\Domain\NomeDoDominio\Models\NomeDoDominio;

final class EloquentNomeDoDominioRepository implements NomeDoDominioRepositoryInterface
{
    public function findByClientId(int $clientId)
    {
        return NomeDoDominio::where('client_id', $clientId)->first();
    }
}
```

### 3.3. BaseCachingRepository (Abstração)
Para evitar duplicação de código na camada de cache, utilizamos uma classe base abstrata que padroniza a injeção do Repositório de Cache e o uso de Tags.

```php
// app/Repositories/BaseCachingRepository.php
namespace App\Repositories;

use Illuminate\Cache\Repository as CacheRepository;
use Closure;

abstract class BaseCachingRepository
{
    protected CacheRepository $cache;

    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Remember a value in cache with tags.
     *
     * @param string $key
     * @param int $ttl Minutes
     * @param array $tags
     * @param Closure $callback
     * @return mixed
     */
    protected function remember(string $key, int $ttl, array $tags, Closure $callback): mixed
    {
        return $this->cache->tags($tags)->remember($key, $ttl * 60, $callback);
    }
}
```

### 3.4. Implementação Caching (Decorator)
Estende `App\Repositories\BaseCachingRepository`. Intercepta chamadas para adicionar cache com **Tags**. **Deve ser `final` e usar `declare(strict_types=1);`**.

**Conceito Chave:** Uso de Tags para invalidação granular. Ex: `nome_do_dominio_transactions:{client_id}`.

```php
declare(strict_types=1);

// app/Domain/NomeDoDominio/Repositories/Caching/CachingNomeDoDominioTransactionRepository.php
namespace App\Domain\NomeDoDominio\Repositories\Caching;

use App\Repositories\BaseCachingRepository;
use App\Domain\NomeDoDominio\Repositories\Contracts\NomeDoDominioTransactionRepositoryInterface;
use Illuminate\Cache\Repository as CacheRepository;
use App\Domain\NomeDoDominio\Models\NomeDoDominioTransaction;

final class CachingNomeDoDominioTransactionRepository extends BaseCachingRepository implements NomeDoDominioTransactionRepositoryInterface
{
    public function __construct(
        protected NomeDoDominioTransactionRepositoryInterface $repository, 
        CacheRepository $cache,
        protected NomeDoDominioTransaction $model
    ) {
        parent::__construct($cache);
    }

    // Exemplo de método com Cache Taggeado
    public function getByClientId(int $clientId, int $perPage = 15)
    {
        // Define a tag baseada no ID do cliente, usando o getCacheTag do Model
        $baseTag = $this->model->getCacheTag();
        $tags = ["{$baseTag}:{$clientId}"];
        
        // Chave única para o cache
        $key = "{$baseTag}.list.{$clientId}.page." . request()->get('page', 1);

        // Uso do remember do BaseCachingRepository (TTL em minutos)
        return $this->remember($key, 60, $tags, function () use ($clientId, $perPage) {
            return $this->repository->getByClientId($clientId, $perPage);
        });
    }

    // Redireciona chamadas não cacheadas para o repositório original
    public function __call($method, $parameters)
    {
        return $this->repository->$method(...$parameters);
    }
}
```

## 4. Observers e Invalidação de Cache

Os Observers são responsáveis por acionar a limpeza de cache quando uma escrita (Create, Update, Delete) ocorre. A lógica de *quais* caches limpar deve ser centralizada no Model, permitindo reutilização e fácil manutenção.

**Regra Importante:** A invalidação deve ser **granular**. Nunca limpe todas as tags se puder limpar apenas a tag específica do cliente ou outro relacionamento afetado.

### 4.1. Implementação no Model

O Model deve utilizar a trait `App\Support\Traits\ClearsCacheOnChanges` e implementar o método `getCacheInvalidationRules()` para definir quais relacionamentos afetam quais tags de cache.

```php
// app/Domain/NomeDoDominio/Models/NomeDoDominioTransaction.php
namespace App\Domain\NomeDoDominio\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Traits\ClearsCacheOnChanges;

class NomeDoDominioTransaction extends Model
{
    use ClearsCacheOnChanges;

    /**
     * Get the base cache tag for the model.
     *
     * @return string
     */
    public function getCacheTag(): string
    {
        return 'nome_do_dominio_transactions';
    }

    /**
     * Get the cache invalidation rules for the model.
     * Returns an array mapping foreign keys to cache tag prefixes.
     *
     * @return array<string, array<string>>
     */
    public function getCacheInvalidationRules(): array
    {
        return [
            // Se transaction tem client_id, limpa a tag "nome_do_dominio_transactions:{client_id}"
            'client_id' => ['nome_do_dominio_transactions'],
            
            // Se afetar outros domínios, adicione aqui
            // 'order_id' => ['orders', 'order_plans'],
        ];
    }
}
```

### 4.2. Implementação no Observer

O Observer deve apenas chamar o método `invalidateCache()` provido pela trait.

```php
// app/Domain/NomeDoDominio/Observers/NomeDoDominioTransactionObserver.php
namespace App\Domain\NomeDoDominio\Observers;

use App\Domain\NomeDoDominio\Models\NomeDoDominioTransaction;

class NomeDoDominioTransactionObserver
{
    public function created(NomeDoDominioTransaction $transaction): void
    {
        $transaction->invalidateCache();
    }

    public function updated(NomeDoDominioTransaction $transaction): void
    {
        $transaction->invalidateCache();
    }

    public function deleted(NomeDoDominioTransaction $transaction): void
    {
        $transaction->invalidateCache();
    }
}
```

## 5. Services e Controllers

### 5.1. Services
Contêm a regra de negócio. Devem depender da **Interface** do repositório, não da implementação concreta.

```php
class NomeDoDominioService
{
    protected $repository;

    // Injeção de Dependência via Interface
    public function __construct(NomeDoDominioRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    // Métodos de negócio...
}
```

### 5.2. Controllers
Controllers devem ser magros, delegando lógica para Services e validação para FormRequests.

## 6. Camada HTTP (Controllers e Requests)

A camada HTTP deve ser responsável apenas por receber a requisição, validar os dados e devolver a resposta. Toda a regra de negócio deve estar no Service.

### 6.1. FormRequests

Use FormRequests para validação. Eles devem ser específicos para cada ação (Create, Update, Delete, Filter).

**Exemplo de FormRequest (Create/Billed):**

```php
namespace App\Domain\NomeDoDominio\Http\Requests\Admin\NomeDoDominio;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\FormRequest\HasValidatedData;

class NomeDoDominioCreateFormRequest extends FormRequest
{
    use HasValidatedData; // Trait para facilitar acesso aos dados validados

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Merge de parâmetros da rota se necessário
        if ($this->route('id')) {
            $this->merge(['id' => $this->route('id')]);
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'min:3', 'max:255'],
            'status' => ['required', 'boolean'],
            // Use regras customizadas para validações complexas
            'document_id' => ['required', new DocumentByDocumentIdRule($this->input('document_id'))],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            // ...
        ];
    }
}
```

### 6.2. Controllers

Os controllers devem seguir um padrão estrito de tratamento de exceções e retorno de recursos (Resources).

**Estrutura Padrão:**

*   **Injeção de Dependência:** O Service deve ser injetado no construtor.
*   **Tratamento de Erros:** Use `try/catch` em todos os métodos.
*   **Log de Erros:** Use a trait `HasErrorLogging` para logar exceções.
*   **Resources:** Retorne `JsonResource` (Resource ou Collect) para transformar os dados.

**Exemplo Completo de Controller:**

```php
namespace App\Domain\NomeDoDominio\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\NomeDoDominio\Services\NomeDoDominioService;
use App\Domain\NomeDoDominio\Http\Requests\Admin\NomeDoDominio\NomeDoDominioCreateFormRequest;
use App\Domain\NomeDoDominio\Http\Requests\Admin\NomeDoDominio\NomeDoDominioUpdateFormRequest;
use App\Domain\NomeDoDominio\Http\Resources\Admin\NomeDoDominio\NomeDoDominioResource;
use App\Domain\NomeDoDominio\Http\Resources\Admin\NomeDoDominio\NomeDoDominioCollect;
use App\Support\Traits\HasErrorLogging;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

final class NomeDoDominioController extends Controller
{
    use HasErrorLogging;

    public function __construct(
        private readonly NomeDoDominioService $service,
    ) {}

    public function index(FilterNomeDoDominioRequest $request): JsonResponse|NomeDoDominioCollect
    {
        try {
            $filters = $request->getFilters(); // Método customizado no Request de filtro
            $result = $this->service->index($filters);
            return new NomeDoDominioCollect($result);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao listar', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao listar'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(NomeDoDominioCreateFormRequest $request): JsonResponse|NomeDoDominioResource
    {
        try {
            $result = $this->service->store($request->validatedData());
            return (new NomeDoDominioResource($result))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao criar', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao criar'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id): JsonResponse|NomeDoDominioResource
    {
        try {
            $result = $this->service->show($id);
            return new NomeDoDominioResource($result);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Não encontrado'], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao exibir', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao exibir'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(NomeDoDominioUpdateFormRequest $request, int $id): JsonResponse|NomeDoDominioResource
    {
        try {
            $result = $this->service->update($id, $request->validatedData());
            return new NomeDoDominioResource($result);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Não encontrado'], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao atualizar', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao atualizar'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Removido com sucesso'], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Não encontrado'], Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            $this->logError($exception, 'Erro ao remover', get_called_class().'@'.__FUNCTION__);
            return response()->json(['message' => 'Erro ao remover'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
```

### 6.3. Rotas

As rotas devem ser definidas dentro do próprio domínio para manter a modularidade, evitando arquivos de rotas globais gigantescos e de difícil manutenção.

**Localização:** `app/Domain/{DomainName}/Routes/api.php`

**Carregamento:**
As rotas devem ser carregadas no método `boot` do `{DomainName}ServiceProvider`.

```php
// app/Domain/NomeDoDominio/Providers/NomeDoDominioServiceProvider.php

public function boot(): void
{
    $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
}
```

**Estrutura do Arquivo de Rotas:**
Use os mesmos padrões de prefixos e middlewares da aplicação global, mas definidos localmente.

```php
// app/Domain/NomeDoDominio/Routes/api.php

use Illuminate\Support\Facades\Route;
use App\Domain\NomeDoDominio\Http\Controllers\Admin\NomeDoDominioController;

Route::middleware(['api', 'auth:api'])->group(function () {
    
    // Admin Routes
    Route::prefix('api/admin/nome-do-dominio')
        ->name('api.admin.nome-do-dominio.')
        ->group(function () {
            Route::get('/', [NomeDoDominioController::class, 'index'])->name('index');
            Route::post('/', [NomeDoDominioController::class, 'store'])->name('store');
            Route::get('/{id}', [NomeDoDominioController::class, 'show'])->name('show');
            Route::put('/{id}', [NomeDoDominioController::class, 'update'])->name('update');
            Route::delete('/{id}', [NomeDoDominioController::class, 'destroy'])->name('destroy');
        });
});
```

**Importante:**
*   Não adicione rotas deste domínio nos arquivos globais `routes/api.php` ou `routes/api/*`.
*   Se houver rotas duplicadas nos arquivos globais, elas devem ser removidas ou comentadas.

## 7. Resumo para Implementação por IA

Ao criar um novo domínio seguindo este padrão, a IA deve:

1.  **Criar a estrutura de pastas** em `app/Domain/{DomainName}`.
2.  **Criar os Service Providers**:
    *   `{DomainName}ServiceProvider` (registrar no AppServiceProvider global).
    *   `RepositoryServiceProvider` (registrar bindings com decorator de cache).
    *   `{DomainName}EventServiceProvider` (registrar observers).
3.  **Implementar Repositórios**:
    *   Interface.
    *   Eloquent (Lógica de DB).
    *   Caching (Lógica de Cache e Tags, estendendo `BaseCachingRepository`).
4.  **Implementar Observers**:
    *   Garantir limpeza de cache granular usando as mesmas Tags definidas no Repositório de Cache.
5.  **Implementar Rotas**:
    *   Criar `Routes/api.php` no domínio.
    *   Carregar rotas no `boot` do Service Provider principal do domínio.
6.  **Implementar Camada HTTP**:
    *   **FormRequests**: Criar Requests específicos para validação (Create, Update, Filter).
    *   **Controller**: Usar `try/catch`, `HasErrorLogging`, injetar Service e retornar `JsonResource`.
7.  **Seguir injeção de dependência**:
    *   Service depende de RepositoryInterface.
    *   Controller depende de Service.
