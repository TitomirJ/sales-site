<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
|--------------------------------------------------------------------------
| Основные маршруты приложения
|--------------------------------------------------------------------------
|
| Тут приведены основные роуты для функционирования приложения
|   без групировки посредниками и префиксами
*/

//Роут лендинга(страница приветствия)
Route::get('/', 'HomeController@welcome')->name('welcome');
Route::post('/call/back/order', 'HomeController@callBackOrder');
Route::get('/welcome', 'HomeController@index')->name('welcome_index');

//Роуты по авторизации, регистрации и завершении сеанса работы
Auth::routes();

//Перехват редиректа на страницу /home
Route::get('/home', function (){
    return redirect('/')->with('danger', 'Не допустимое действие, в доступе отказано!');
})->name('home');

//Перехват на баланс
Route::get('check/company/balance', 'HomeController@checkBalanceRedirect');

//Роуты загрузки катринок на сайт Dropzone
Route::post('/dropzone/uploadFiles', 'DropzoneImageController@uploadFiles');
Route::post('/dropzone/deleteFiles', 'DropzoneImageController@deleteFiles');

//Создание компании пользоателем
Route::get('/company/reg', 'UserController@showRegFormCompany')->name('show_reg_form_company');
Route::post('/company/create', 'UserController@createCompany')->name('create_new_company');
Route::get('/company/type/form', 'UserController@loadTypeCompanyForm');

//Личный кабинет пользователя
Route::get('/user/profile', 'UserController@showProfileUser')->name('show_profile_user');
Route::post('/change/profile', 'UserController@changeProfileUser')->name('change_profile_user');
Route::post('/change/password', 'UserController@changePasswordUser')->name('change_pasword_user');

//Прочие
Route::get('/agreement', function(){
    return view('other.agreement');
});
Route::get('/privacy', function(){
    return view('other.privacy');
});
Route::get('/about', function(){
    return view('other.about');
});
Route::get('/question', function(){
    return view('other.question');
});
Route::get('/standarts', function(){
    return view('other.standarts');
});


/*
|--------------------------------------------------------------------------
| Маршруты для администрации сайта и модераторов
|--------------------------------------------------------------------------
|
| Тут приведены основные роуты для администрирования и контроля
|   за деятельностью пользователей сайта, для удобства маршруты
|   разбиты на группы посредников и преффиксов
*/

//Группа роутов для старшего администратора сайта
Route::group(['middleware' => ['superAdmin']], function () {

    // Группа роутов с префиксом admin/
    Route::prefix('admin')->group(function () {
        Route::get('/personnel/admin/{id}/delete', 'SuperAdminController@adminDelete')->name('superAdmin_personnel_admin_delete');
        Route::get('/personnel/{id}/promotion', 'SuperAdminController@personnelUp')->name('superAdmin_personnel_up');
        Route::get('/personnel/{id}/downgrading', 'SuperAdminController@personnelDown')->name('superAdmin_personnel_down');

        //Удаление компании
        Route::get('/delete/company/{id}', 'AdminCompanyController@companyDelete');
        //удаление товаров
        Route::get('/product/{id}/forcedelete', 'SuperAdminController@forceDeleteProduct');
        // Роуты для управлением агента по компаниям
        Route::get('/agents', 'SuperAdminController@agents');

		//Роут для отчета об автообновлении компаний(март2020)
        Route::get('/update_auto_info','SuperAdminController@infoUpdateAuto');


        //Удаление форс всех товаров компании(!даже если есть у них заказы, пользоваться осторожно)
        Route::get('/delete/forse/products/{id}', 'SuperAdminController@forseDeleteProductsWithImageFromAmazonAndProductItems');
    });
});


//Группа роутов для (администраторов И! модераторов) сайта
Route::group(['middleware' => ['adminOrModerator']], function () {

    // Группа роутов с префиксом admin/
    Route::prefix('admin')->group(function () {

        //Гланая админ панели с общим доступом для админа и модератора
        Route::get('/', 'AdminController@indexBrief')->name('show_admin_index');

        //Страница сотрудников сайта
        Route::get('/personnel', 'AdminController@personnelIndex')->name('admin_personnel_index');

        //Страница пользователей сайта без компании
        Route::get('/moderation/users', 'AdminUserController@index');
        Route::get('/moderation/users/{id}/delete', 'AdminUserController@deleteGuest');

        //companies
        Route::get('/companies', 'AdminCompanyController@companiesIndex');
        Route::get('/filter/companies', 'AdminCompanyController@filterCompaniesIndex');//Фильтр компаний
        Route::get('/company/{id}', 'AdminCompanyController@companyIndex')->name('admin_company_show');
        Route::get('/company/{id}/edit', 'AdminCompanyController@companyEdit');
        Route::get('/company/type/form', 'AdminCompanyController@loadTypeCompanyForm');
        Route::post('/company/{id}/update', 'AdminCompanyController@companyUpdate');
        Route::get('/company/{id}/filter/{type}', 'AdminCompanyController@companyIndexFilter');
        Route::get('/company/{id}/recalculation/balance', 'AdminCompanyController@recalculationCompanyBalance');
        Route::get('/search/company', 'AdminCompanyController@companySearch');


		// для удаления дубликатов товаров
        Route::get('/company/{id}/del_clons','AdminCompanyController@clons')->name('clons');
		Route::post('/company/all_delclons','AdminCompanyController@all_delclons')->name('all_delclons');

        //notifications
        Route::get('/notification/{id}/confirm', 'Notification\NotificationAdminController@confirmNoficationAdmin');


        //Ресурс роуты модерации товаров
        Route::resource('/moderation/products', 'ModerationProductsController', ['except' => [
            'create', 'store'
        ]]);


        Route::get('/moderation/products/{id}/chprice', 'ModerationProductsController@successCheckPriceProduct');
        Route::post('/product/{id}/{action}', 'ModerationProductsController@actionsWithProduct');
            // AJAX запросы модерации товаров
            Route::post('/success/product', 'ModerationProductsController@successModerationProduct');
            Route::post('/warning/product', 'ModerationProductsController@returnProductToCompanyAfterModeration');
            Route::post('/danger/product', 'ModerationProductsController@blockCompanyProduct');
        //роуты модерации товаров(версия 2 в разработке)
        Route::any('/moderation/products/{type}/filter', 'ModerationProductsController@filterProductsModaration');

        //Ресурс роуты модерации заказов
        Route::resource('/moderation/orders', 'ModerationOrdersController', ['except' => [
            'create', 'store'
        ]]);

        // ресурс контролер для управления чатами
        Route::resource('rozetka/chats', 'Rozetka\AdminChatsController');
        Route::post('rozetka/actions/chats', 'Rozetka\AdminChatsController@groupActionsChart');

            // AJAX запросы модерации заказов
        Route::get('/moderation/order/{id}/show/modal', 'ModerationOrdersController@showActionModal');
        Route::post('/moderation/order/action', 'ModerationOrdersController@actionWithModerOrders');

        // AJAX запросы
        Route::get('/get/subcategory/options', 'ModerationProductsController@getSubcategoryOptions');
        Route::get('/moderation/product/render/input', 'ModerationProductsController@getRenderInput');
        Route::get('/moderation/product/render/yourself/input', 'ModerationProductsController@getYourSelfInput');
    });
});


//Группа роутов только!!! для  администраторов сайта
Route::group(['middleware' => ['admin']], function () {
    // Группа роутов с префиксом admin/
    Route::prefix('admin')->group(function () {
        // Группа роутов с префиксом admin/blog/
        Route::prefix('blog')->group(function () {
            //Группа роутов для блога
            Route::get('/', 'AdminBlogController@index')->name('admin_blog_index');
            Route::get('/{id}/show', 'AdminBlogController@show')->name('admin_blog_show');
            Route::get('/create', 'AdminBlogController@create')->name('admin_blog_create');
            Route::post('/store', 'AdminBlogController@store')->name('admin_blog_store');
            Route::get('/edit/{id}', 'AdminBlogController@edit')->name('admin_blog_edit');
            Route::post('/update/', 'AdminBlogController@update')->name('admin_blog_update');
            Route::post('/{id}/block', 'AdminBlogController@changeStatusBlog')->name('admin_blog_change_status');
            Route::get('/{id}/delete', 'AdminBlogController@delete')->name('admin_blog_delete');
        });

        // Группа роутов с префиксом admin/personnel/
        Route::prefix('personnel')->group(function () {
            //Группа роутов для управления сотрудниками сайта администратором
            Route::get('/create', 'Auth\RegisterModeratorController@create')->name('admin_personnel_create');
            Route::post('/store', 'Auth\RegisterModeratorController@store')->name('admin_personnel_store');
            Route::get('/moderator/{id}/delete', 'AdminController@moderatorDelete')->name('admin_personnel_moderator_delete');
        });

        // Группа роутов с префиксом admin/review/
        Route::prefix('review')->group(function () {
            //Группа роутов для слайдера с отзывами
            Route::get('/', 'AdminReviewController@index')->name('admin_review_index');
            Route::get('/{id}/show', 'AdminReviewController@show')->name('admin_review_show');
            Route::get('/create', 'AdminReviewController@create')->name('admin_review_create');
            Route::post('/store', 'AdminReviewController@store')->name('admin_review_store');
            Route::get('/edit/{id}', 'AdminReviewController@edit')->name('admin_review_edit');
            Route::post('/update/', 'AdminReviewController@update')->name('admin_review_update');
            Route::post('/{id}/block', 'AdminReviewController@changeStatusReview')->name('admin_review_change_status');
            Route::get('/{id}/delete', 'AdminReviewController@delete')->name('admin_review_delete');
        });

        //Ресурс роуты для тематик
        Route::resource('themes', 'AdminThemeController', ['except' => [
        'create', 'store', 'edit', 'update', 'destroy'
        ]]);
        Route::get('/search/theme', 'AdminThemeController@search')->name('admin_search_theme');

        //Ресурс роуты для категорий
        Route::resource('categories', 'AdminCategoryController');
        Route::get('/search/category', 'AdminCategoryController@search')->name('admin_search_category');

        //Ресурс роуты для подкатегорий
        Route::resource('subcategories', 'AdminSubcategoryController');
        Route::get('/search/subcategory', 'AdminSubcategoryController@search')->name('admin_search_subcategory');
        Route::get('/check/subcategory/{id}', 'AdminSubcategoryController@check')->name('admin_check_subcategory');
        Route::post('/update/params/subcategory/{id}', 'AdminSubcategoryController@updateParamsSubcat');//обновление и создание характеристик подкатегории через Excel файл
        // Роуты для создания и обновления характеристик товаров через АПИ Розетки
        Route::get('api/rozetka/subcategory', 'Rozetka\AdminRozetkaApiController@apiCreateFromRozetka');
        Route::get('api/rozetka/subcat/search', 'Rozetka\AdminRozetkaApiController@apiSearchSubcatRozetka');
        Route::get('api/show/params/{type}/{id}', 'Rozetka\AdminRozetkaApiController@showSubcatParams');
            // Роуты для работы с подкатегориями Розетки
            Route::post('api/rozetka/subcategory/{id}', 'Rozetka\AdminRozetkaApiController@updateSubcategoryParams');
            Route::post('api/rozetka/subcategory/with/params', 'Rozetka\AdminRozetkaApiController@createSubcategoryWithRozetkaParams');




        //роуты для заказов
        Route::resource('orders', 'AdminOrderController', ['except' => [
            'edit', 'update', 'destroy'
        ]]);
        Route::get('order/{id}', 'AdminOrderController@showOrder');
        Route::get('order/{id}/delivery', 'AdminOrderController@changeStatusDelOrders');
        Route::get('order/{id}/create/job', 'AdminOrderStatusController@createJobCheckStatus');
		//ручная смена статуса на розетке
		Route::get('order/{id}/create/job/{market}', 'AdminOrderStatusController@checkStatusNow');
        //Роуты компаний
            // Управление транзакциями администратором
            Route::get('/transactions', 'AdminCompanyController@balanceIndex');
            Route::post('/transactions/store/', 'AdminTransactionController@storeNewTransaction');
            //Замечания к компании для блокировки
            Route::get('/companies/warnings', 'AdminCompanyController@companyWarnings');
            Route::get('/company/{id}/warnings/modal/show', 'AdminCompanyController@showModalAction');
            Route::post('/company/{id}/warnings/modal/action', 'AdminCompanyController@actionModalAction');
            // Принудительный вывод или отправка товаров на маркетплейсы
            Route::post('/company/{id}/products/move-marketplace', 'AdminCompanyController@goProductsToMarketOrOut');
            // Изменение статуса заказа компании(пока только с нового на проверенный и без отправки смены статуса на маркеты)
            Route::any('/company/order/{id}/change-status', 'AdminOrderStatusController@changeStatusOrder');
            // Изменение тарифа компании администратором
            Route::post('/company/tariff/change', 'AdminCompanyController@changeTariffPlanCompany');



        // Группа роутов по интеграции пользователями товаров ЮМЛ файлов
        Route::prefix('prom')->group(function () {
            // Роуты сводки по интеграции пользователями товаров ЮМЛ файлов
            Route::get('/', 'Prom\AdminPromController@index');
            // Группа роутов ссылок и файлов ЮМЛ
            Route::resource('/externals', 'Prom\AdminPromExternalController');
            Route::post('/externals/{id}/action', 'Prom\AdminPromExternalController@action');
            Route::get('/external/{id}/categories', 'Prom\AdminPromExternalController@externalCategoriesIndex');
            Route::get('/external/{id}/products', 'Prom\AdminPromExternalController@externalProductsIndex');
            // Группа роутов подкатегорий прома
            Route::resource('/categories', 'Prom\AdminPromCategoriesController');
            // Группа роутов товаров прома
            Route::resource('/products', 'Prom\AdminPromProductController');
            //операции с товарами во временном хранилище
            Route::get('/product/{id}/{action}', 'Prom\AdminPromProductController@productsExternalActions');

        });
    });
});


//Группа роутов только!!! для модераторов сайта
Route::group(['middleware' => ['moderator']], function () {

});


/*
|--------------------------------------------------------------------------
| Маршруты для поставщиков и компаний
|--------------------------------------------------------------------------
|
| Тут приведены основные роуты для пользователей сайта(поставщиков)
|    для удобства маршруты разбиты на группы посредников и преффиксов
*/

//Редирект на заблокированую компанию
Route::get('/company/blocked', 'ProviderController@companyBlocked');

/** Роут для платежной системы **/
Route::post('/liqpay/status', 'ProviderBalanceController@liqpayStatus')->middleware('auth');
Route::post('/liqpay/server', 'ProviderBalanceController@liqpayServer');

/*      Группа роутов для пользователей компании с отрицательным балансом и абонементом      */
Route::group(['middleware' => ['provider', 'checkBlockedCompany']], function () {
    Route::get('/help', 'ProviderController@showJivoSite');

    Route::prefix('company')->group(function () {
        // Группа роутов для управления балансом компании
        Route::get('/balance', 'ProviderBalanceController@index');

        //AJAX запросы по балансу
        Route::get('/balance/get/select/pay', 'ProviderBalanceController@getSelectPayForm');
        Route::post('/balance/get/liqpay/form', 'ProviderBalanceController@getLiqpayForm');
        Route::get('/balance/cancel/liqpay', 'ProviderBalanceController@cancelPayBalAndAb');
    });
});

/*      Группа роутов для пользователей компании     (, 'checkBalanceBlock')- посредник для блокировки абонемента */
Route::group(['middleware' => ['provider', 'checkBlockedCompany', 'checkAbonimentBlock']], function () {


    // Группа роутов с префмксом company/
    Route::prefix('company')->group(function () {

        Route::get('/', 'ProviderController@showCompany')->name('show_company');//Главная страница компании
        Route::get('/personnel', 'ProviderController@showPersonnelCompany')->name('show_personnel_company');//Показать персоналл компании

        //Ресурс роуты для управления товарами поставщиком
        Route::resource('products', 'ProviderProductController', ['except' => [
            'destroy'
        ]]);

		//Роут для добавления ключевых слов поиска товара
        Route::get('product/keywords/{id}', 'ProviderProductController@getitem')->name('addwords');
        Route::post('product/add_keywords', 'ProviderProductController@addWord');
        Route::post('product/del_keywords', 'ProviderProductController@delWord');
        Route::post('product/all_destroy', 'ProviderProductController@alldelWord')->name('alldelwords');
        Route::post('product/add_on_subcategory_words', 'ProviderProductController@subAddWord')->name('addinsubcatwords');
        Route::post('product/del_subcategory_words', 'ProviderProductController@clearAllSubCatWords')->name('delsubcatwords');

		//Роуты для сохранения настроек автообновления через xml файл (февраль 2020)
        Route::post('product/autoupdate', 'ProviderProductController@autoUpdateBtn');
        Route::post('product/make_setting_autoupdate', 'ProviderProductController@makeSettingAutoupdate');


        Route::resource('update/products', 'ProviderUpdateProductController');
        // переписка с покупателями
        Route::resource('messages', 'ProviderMessagesController');
        Route::post('actions/messages', 'ProviderMessagesController@groupActionsChart');


        //тестовые роуты для создания ЛИСТ

        Route::get('/change/prit', 'ProviderProductController@changeProitTest');//test rout

        Route::get('/filter/products/{type}', 'ProviderProductController@providerProductsFilter');//test rout


        Route::get('/test/product/index', 'ProviderProductController@indexNew');//test rout
        Route::get('/test2/product/index', 'ProviderProductController@indexToNew');//test rout
        Route::get('/test/create', 'ProviderProductController@test');//test rout
        Route::get('/test/edit', 'ProviderProductController@edit2');//test rout
        Route::get('/test/clon', 'ProviderProductController@clon2');//test rout

        Route::post('/short_edit/product/{id}', 'ProviderProductController@shortUpdateProduct');
        Route::get('/products/{id}/clone', 'ProviderProductController@showCloneForm');//Показать форму клонирования товара

        // Группа роутов для управления заказами поставщиком
        Route::get('/orders', 'ProviderOrderController@index');
        //Route::any('/orders/{id}/{action}', 'ProviderOrderController@ordersActions');
        Route::get('/filter/orders', 'ProviderOrderController@companyOrderIndexFilter');
        Route::get('/orders/product/{id}', 'ProviderOrderController@searchOrdersFromProduct');

        // Группа роутов для управления интеграциями компании
        Route::get('/integrations', 'ProviderIntegrationController@index');

        //Требования к созданию товара спецификация Розетки
        Route::get('/product/rules', 'ProviderProductController@infoRozetParametr');

        //Группа роутов для ипорта товаров
        Route::resource('/externals', 'Prom\ProviderPromExternalController');
//        Route::get('/external/rule', 'Prom\ProviderPromExternalController@rules');

		//роут для бэкапа автообновления (март2020)
        Route::post('/audbackup','Prom\ProviderBackupController@audbackup')->name('audbackup');


        // AJAX запросы
        Route::get('/product/delete', 'ProviderProductController@deleteProduct');
        //Route::any('/change/status/order/{id}', 'ProviderOrderController@changeStatusOrder');// old rout change status order
        Route::any('/edit/status/order/{id}', 'ProviderOrderStatusController@changeStatusOrder');// new rout change status order
        Route::get('/check/edit/product/{id}', 'ProviderProductController@checkEditProduct');
        //Route::get('/check/create/product/name', 'ProviderProductController@checkCreateProductName'); //роут для проверки идентичных названий товаров, пока в разработке
        Route::get('/load/short_form/edit/{id}', 'ProviderProductController@showShortEditForm');
        Route::post('/products/group/actions', 'ProviderProductController@productsGroupActions');
        Route::get('/get/subcategories', 'ProviderProductController@getSubcategories');
        Route::get('/get/subcategory/options', 'ProviderProductController@getSubcategoryOptions');
        Route::get('/product/render/input', 'ProviderProductController@getRenderInput');
        Route::get('/product/render/yourself/input', 'ProviderProductController@getYourSelfInput');
        Route::get('/check/code', 'ProviderProductController@checkCodeProduct');
        Route::post('/product/{id}/available', 'ProviderProductController@changeProductStatusAvailable');
        Route::post('/usetting/pag', 'ProviderProductController@changePaginationOnProductPage');//Изменить пагинацию пользователя
    });
});


//Группа роутов для владельца компании (, 'checkBalanceBlock')- посредник для блокировки абонемента
Route::group(['middleware' => ['providerAndDirector', 'checkBlockedCompany', 'checkAbonimentBlock']], function () {
    // Группа роутов с префмксом company/
    Route::prefix('company')->group(function () {
        // Добавление менеджера директором
        Route::get('/add/manager', 'Auth\RegisterManegerController@showFormCreateNewManeger')->name('show_form_creat_new_maneger');
        Route::post('/add/manager', 'Auth\RegisterManegerController@createNewManeger')->name('create_new_maneger');

        //Удаление менеджера компании директором
        Route::any('/manager/{id}/delete', 'ProviderDirectorController@managerDelete')->name('company_manager_delete');

        // Личный кабинет компании для внесения изменений
        Route::get('/profile', 'ProviderDirectorController@showProfileCompany')->name('show_profile_company');
        Route::get('/profile/render/form', 'ProviderDirectorController@renderFormLegalCompany');
        Route::post('/profile', 'ProviderDirectorController@changeProfileCompany')->name('change_profile_company');

    });
});


//Группа роутов для менеджера компании (, 'checkBalanceBlock')- посредник для блокировки абонемента
Route::group(['middleware' => ['providerAndManeger', 'checkBlockedCompany', 'checkAbonimentBlock']], function () {

});


/*
|--------------------------------------------------------------------------
| Маршруты для АПИ без посредника запроса
|--------------------------------------------------------------------------
|
| Тут приведены основные роуты АПИ запросов(временно перенесен в web.php, до окончания разработки андроид)
*/
Route::prefix('api')->group(function () {
    Route::post('/company/balance/set', 'ApiHerokuController@recheckBalanceCompany');
    Route::post('/image/upload', 'ApiHerokuController@uploadImgForVova');

    Route::post('/xml/upload/rozetka', 'ApiHerokuController@uploadXmlRozetka');
    Route::post('/xml/upload/prom', 'ApiHerokuController@uploadXmlProm');
    Route::post('/xml/upload/zakupka', 'ApiHerokuController@uploadXmlZakupka');
    Route::get('/xml/get/rozetka', 'ApiHerokuController@getXmlRozetka');
    Route::get('/xml/get/prom', 'ApiHerokuController@getXmlProm');
    Route::get('/xml/get/zakupka', 'ApiHerokuController@getXmlZakupka');
});


/*
|--------------------------------------------------------------------------
| Маршруты для BigMarketing.com.ua, мультивалютная платежная система
|--------------------------------------------------------------------------
|
| Тут приведены основные роуты единоразовых платежей разной валюты для BigMarketing.com.ua
*/
Route::prefix('bigmarketing')->group(function () {
    Route::get('/pay', 'BigMarketing\BMController@index');
    Route::post('/pay', 'BigMarketing\BMController@createPayForm');
    Route::get('/balance', 'BigMarketing\BMController@balance');

    Route::post('/liqpay/status', 'BigMarketing\BMBalanceController@liqpayStatus');
    Route::post('/liqpay/server', 'BigMarketing\BMBalanceController@liqpayServer');
});


/*
|--------------------------------------------------------------------------
| Маршруты для планировщика задач
|--------------------------------------------------------------------------
|
| Тут приведены основные роуты планиировщика задач для выполнения основных задач сайта
*/
Route::prefix('cron')->group(function () {
    // проверка абонплаты пользователей, блокирует абонплату и выводит товары с маркетплейсов
    Route::get('/company/aboniment/WyJrYKHHbROT9uP', 'CronController@checkAbonimentCompany');
    // выводит заказы пользователей в статус "Отменен" без возмещения комиссии компании
    Route::get('/company/cancel/order/KHHbROWyJrYROT9uP', 'CronController@cancelOrderCompany');
    // вспомогательный роут для подготовки характеристик подкатегорий(На данный момент не актулен!)
    Route::get('/parcing', 'CronController@parcing');
    // очищает хостинг от не нужных и неиспользуемых изображений(инициализаций каждый день в полночь)
    Route::get('/delete/images/KHHbROWyJrYROT9uP', 'CronController@deleteTrashImages');
    // создание уведомления о том что у компании меньше 12 часов до блокировки абонплаты
    Route::get('/check/company/aboniment/for/notify', 'CronController@checkCompanyAbonimentForNotifyAdmin');

	// автообновление товаров компании через xml загруженный ранее (февраль 2020)
    Route::get('/autonew','CronController@autonew');

    // Группа роутов для проверки и создания товаров из XML ссылок пользователей
    Route::prefix('yml')->group(function () {
        //крон проверки ЮМЛ товаров
        Route::get('/preaudit/products', 'Prom\CronPromProductController@predAuditProductYml');
        Route::get('/audit/products', 'Prom\CronPromProductController@auditProductYml');
        //крон загрузки провереных ЮМЛ товаров
        Route::get('/upload/products', 'Prom\CronPromProductController@uploadAuditedProductsToCompany');
    });

});




//Группа роутов для test\
    Route::get('/test', 'HomeController@options');
    Route::get('/test/notif', 'HomeController@testNotifForAdmin');
//Route::get('/test2', 'ApiHerokuController@orderShipped');CronController
 //   Route::get('/test/send/email', 'CronController@sendEmailToProviderAboutAbBlock');
    //Route::get('/back/products', 'HomeController@backProducts');
Route::get('/test/sms', 'HomeController@sendSMS');
    Route::get('/test/ind', 'HomeController@independent');
    Route::get('/test/new', function (){
        return view('landing.index');
    });
Route::get('company/external/rule', 'Prom\ProviderPromExternalController@rules');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

//Route::get('/dostup', function(){
   //$client = new \GuzzleHttp\Client();
            //$response = $client->head('http://134.249.226.227:8080/pic/TOY_BOX/012.jpeg');
	//$response = $client->request('GET', 'http://134.249.226.227:8080/pic/TOY_BOX/012.jpeg', ['allow_redirects' => false]);
            //$status_url = $response->getStatusCode();

	//$status_url = get_headers(trim('http://134.249.226.227/pic/%d0%9c%d0%b0%d0%ba%d1%81%d0%bc%d0%b0%d1%80%d0%ba/%d0%9caxmark/EC-BL221.jpg'));
            //dd($status_url);

//});

//});