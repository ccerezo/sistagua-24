php artisan make:model TipoProducto -m
php artisan make:filament-resource TipoProducto --generate

php artisan make:model Producto -m
php artisan make:filament-resource Producto --generate

php artisan make:model Mese -m
php artisan make:model Grupo -m
php artisan make:filament-resource Grupo --generate
php artisan make:migration create_grupo_mese

php artisan make:model Precio -m
php artisan make:filament-resource Precio --generate

php artisan make:model Categoria -m
php artisan make:filament-resource Categoria --generate

php artisan make:model Domicilio -m
php artisan make:filament-resource Domicilio --generate

php artisan make:model Empresa -m
php artisan make:filament-resource Empresa --generate

php artisan make:model Provincia -m
php artisan make:model Ciudad -m
php artisan make:model Parroquia -m
php artisan make:filament-resource Parroquia --generate

php artisan make:model Direccion -m
php artisan make:filament-relation-manager DomicilioResource direccions direccion
php artisan make:filament-relation-manager Empresa direccions direccion

php artisan make:model TipoContacto -m
php artisan make:filament-resource TipoContacto --generate

php artisan make:model Contacto -m
php artisan make:filament-relation-manager DomicilioResource contactos apellido1
php artisan make:filament-relation-manager EmpresaResource contactos tipo_contacto_id

php artisan make:model Facturar -m
php artisan make:filament-relation-manager DomicilioResource facturars nombre
php artisan make:filament-relation-manager EmpresaResource facturars nombre