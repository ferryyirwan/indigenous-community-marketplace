# Routes

| Method | URI | Name | Action |
|--------|-----|------|--------|
| GET,HEAD | sanctum/csrf-cookie | sanctum.csrf-cookie | Laravel\Sanctum\Http\Controllers\CsrfCookieController@show |
| GET,HEAD | _ignition/health-check | ignition.healthCheck | Spatie\LaravelIgnition\Http\Controllers\HealthCheckController |
| POST | _ignition/execute-solution | ignition.executeSolution | Spatie\LaravelIgnition\Http\Controllers\ExecuteSolutionController |
| POST | _ignition/update-config | ignition.updateConfig | Spatie\LaravelIgnition\Http\Controllers\UpdateConfigController |
| GET,HEAD | api/user | - | Closure |
| GET,HEAD | / | home | App\Http\Controllers\PageController@home |
| GET,HEAD | contact | contact | App\Http\Controllers\PageController@contact |
| POST | contact | contact.send | Closure |
| GET,HEAD | products | products.index | App\Http\Controllers\ProductController@index |
| GET,HEAD | products/{id} | products.show | App\Http\Controllers\ProductController@show |
| GET,HEAD | register | register | App\Http\Controllers\AuthController@showRegisterForm |
| POST | register | - | App\Http\Controllers\AuthController@register |
| GET,HEAD | login | login | App\Http\Controllers\AuthController@showLoginForm |
| POST | login | - | App\Http\Controllers\AuthController@login |
| POST | logout | logout | App\Http\Controllers\AuthController@logout |
| GET,HEAD | check-email | - | Closure |
| GET,HEAD | home | home | App\Http\Controllers\PageController@home |
| POST | buyer/products/{id}/order | buyer.order.store | App\Http\Controllers\OrderController@store |
| GET,HEAD | buyer/orders | buyer.orders | App\Http\Controllers\OrderController@myOrders |
| GET,HEAD | buyer/order/{order}/payment | buyer.payment.show | App\Http\Controllers\PaymentController@show |
| POST | buyer/order/{order}/payment | buyer.payment.store | App\Http\Controllers\PaymentController@store |
| POST | buyer/orders/{id}/cancel | buyer.order.cancel | App\Http\Controllers\OrderController@cancelOrder |
| GET,HEAD | seller/dashboard | seller.dashboard | App\Http\Controllers\ProductController@dashboard |
| GET,HEAD | seller/products/create | seller.products.create | App\Http\Controllers\ProductController@create |
| POST | seller/products | seller.products.store | App\Http\Controllers\ProductController@store |
| GET,HEAD | seller/products/{product} | seller.products.show | App\Http\Controllers\ProductController@show |
| GET,HEAD | seller/products/{product}/edit | seller.products.edit | App\Http\Controllers\ProductController@edit |
| PUT,PATCH | seller/products/{product} | seller.products.update | App\Http\Controllers\ProductController@update |
| DELETE | seller/products/{product} | seller.products.destroy | App\Http\Controllers\ProductController@destroy |
| GET,HEAD | seller/orders | seller.orders | App\Http\Controllers\OrderController@indexForSeller |
| PUT | seller/orders/{order} | seller.orders.update | App\Http\Controllers\OrderController@updateStatus |
| GET,HEAD | seller/payments | seller.payments | App\Http\Controllers\PaymentController@indexForSeller |
| PUT | seller/seller/payments/{id} | seller.payments.update | App\Http\Controllers\PaymentController@updateStatus |
