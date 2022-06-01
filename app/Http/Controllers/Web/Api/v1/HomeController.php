<?php

namespace App\Http\Controllers\Web\Api\v1;

use App\Models\PaymentMethod;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Web\api\v1\BankService;
use App\Services\Web\api\v1\CityService;
use App\Services\Web\api\v1\RoleService;
use App\Services\Web\api\v1\SaleService;
use App\Services\Web\api\v1\UserService;
use App\Services\Web\api\v1\ZoneService;
use App\Services\Web\api\v1\ProductService;
use App\Services\Web\api\v1\CategoryService;
use App\Services\Web\api\v1\CustomerService;
use App\Services\Web\api\v1\DepartmentService;
use App\Services\Web\api\v1\PermissionService;
use App\Http\Resources\Web\api\v1\Bank\BankCollection;
use App\Http\Resources\Web\api\v1\City\CityCollection;
use App\Http\Resources\Web\api\v1\Role\RoleCollection;
use App\Http\Resources\Web\api\v1\User\UserCollection;
use App\Http\Resources\Web\api\v1\Zone\ZoneCollection;
use App\Http\Resources\Web\api\v1\Category\CategoryCollection;
use App\Http\Resources\Web\api\v1\Department\DepartmentCollection;
use App\Http\Resources\Web\api\v1\Permission\PermissionCollection;
use App\Http\Resources\Web\api\v1\PaymentMethod\PaymentMethodCollection;

class HomeController extends Controller
{
    protected $roleService;
    protected $cityService;
    protected $zoneService;
    protected $permissionService;
    protected $departmentService;
    protected $userService;
    protected $bankService;
    protected $categoryService;
    protected $saleService;
    protected $productService;
    protected $customerService;

    public function __construct(
                                CityService $cityService,
                                ZoneService $zoneService,
                                RoleService $roleService,
                                PermissionService $permissionService,
                                DepartmentService $departmentService,
                                CategoryService $categoryService,
                                UserService $userService,
                                BankService $bankService,
                                ProductService $productService,
                                CustomerService $customerService,
                                SaleService $saleService
                                )
    {
        $this->cityService = $cityService;
        $this->zoneService = $zoneService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->departmentService = $departmentService;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->bankService = $bankService;
        $this->saleService = $saleService;
        $this->productService = $productService;
        $this->customerService = $customerService;
        
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = $this->cityService->getAllCities();
        $zones = $this->zoneService->getAllZones();
        $roles = $this->roleService->getRoles();
        $permissions = $this->permissionService->getPermissions();
        $departments = $this->departmentService->getDepartments();
        $users = $this->userService->getUsers();
        $banks = $this->bankService->getBanks();
        $categories = $this->categoryService->getAllCategories();
        $payment_methods = PaymentMethod::orderBy('created_at', 'asc')->get();
        return response()->json(
            [
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'categories' => new CategoryCollection($categories),
                    'departments' => new DepartmentCollection($departments),
                    'cities' => new CityCollection($cities),
                    'zones' => new ZoneCollection($zones),
                    'roles' => new RoleCollection($roles),
                    'permissions' => new PermissionCollection($permissions),
                    'users' => new UserCollection($users),
                    'banks' => new BankCollection($banks),
                    'payment_methods' => new PaymentMethodCollection($payment_methods),
                ]
            ],
            Response::HTTP_OK
        );
    }

    public function dashboard_count()
    {

        $weekly_sale = $this->saleService->getWeeklySale();
        $daily_sale = $this->saleService->getDailySale();
        $sale_summary = $this->saleService->getSaleSummary();
        $product_count = $this->productService->getAllProducts()->count();
        $customer_count = $this->customerService->getCustomers()->count();
        return response()->json(
            [
                'status' => 1,
                'message' => 'Success',
                'data' => [
                    'weekly_sale_amount' => $weekly_sale->sum('grand_total'),
                    'weekly_sale_count' => $weekly_sale->count(),
                    'product_count' => $product_count,
                    'customer_count' => $customer_count,
                    'sale_summary' => $sale_summary,
                    'daily_sale' => $daily_sale,
                    'today_total_cash_transfer' => 0,
                    'hq_accounts' => null,
                    'latest_transactions' => null,
                    'this_month_transaction_count' => 0,
                ]
            ],
            Response::HTTP_OK
        );
    }

    public function clear_transaction()
    {
        // Schema::disableForeignKeyConstraints();
       
        // Journal::truncate();
        // Transaction::truncate();

        // Schema::enableForeignKeyConstraints();

        // Account::where('balance', '>', 0)
        //         ->orWhere('balance', '<', 0)
        //         ->update(array('balance' => 0));
        // $this->firebaseService->removeFirebaseNotiCount();
        // return 'ok';
    }
}
