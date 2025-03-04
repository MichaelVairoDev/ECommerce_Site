# 🛍️ Plataforma de Comercio Electrónico

## 📝 Descripción

Una plataforma de comercio electrónico moderna y completa construida con Laravel, que incluye un catálogo de productos, carrito de compras, sistema de autenticación y más.

## 📸 Capturas de Pantalla

### 🏠 Página de Inicio

![Página de Inicio](/screenshots/home.png)
_Vista del catálogo principal con productos y categorías destacadas_

### 📋 Listado de Productos

![Listado de Productos](/screenshots/list-products.png)
_Vista completa del catálogo de productos_

### 👤 Perfil de Usuario

![Perfil](/screenshots/profile.png)
_Panel de usuario con historial de pedidos_

### 📦 Detalle de Producto

![Detalle de Producto](/screenshots/single-product.png)
_Vista detallada de un producto individual_

## 🚀 Tecnologías Utilizadas

### Frontend

-   🎨 Tailwind CSS para estilos
-   🌐 Plantillas Laravel Blade
-   🔄 Vite para empaquetado de activos
-   📱 Diseño responsivo

### Backend

-   🚀 Laravel 10
-   🗃️ Base de datos SQLite
-   🔐 Autenticación Laravel
-   📝 PHP 8.1+
-   🔄 Eloquent ORM

## 🛠️ Requisitos Previos

-   PHP 8.1 o superior
-   Composer
-   Node.js y NPM
-   Git

## ⚙️ Configuración del Proyecto

1. **Clonar el repositorio**

```bash
git clone https://github.com/MichaelVairoDev/ECommerce_Site.git
cd ECommerce_Site
```

2. **Instalar dependencias**

```bash
composer install
npm install
```

3. **Configuración del entorno**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuración de la base de datos**

```bash
php artisan migrate
php artisan db:seed
```

5. **Compilar assets**

```bash
npm run dev
```

6. **Iniciar el servidor de desarrollo**

```bash
php artisan serve
```

## 📊 Estructura de Datos

El proyecto incluye modelos para:

-   👤 Usuarios
-   📦 Productos
-   🗂️ Categorías
-   🛒 Carrito y Items del Carrito
-   📋 Pedidos y Items de Pedidos
-   ⭐ Reseñas
-   🎫 Cupones

## 🔍 Características Principales

-   🛍️ Catálogo de productos con búsqueda y filtros
-   🛒 Sistema de carrito de compras
-   👤 Autenticación de usuarios
-   💳 Proceso de pago
-   📱 Diseño responsivo
-   🔍 Búsqueda de productos
-   ⭐ Sistema de reseñas y calificaciones
-   🎫 Sistema de cupones

## 🗂️ Estructura del Proyecto

```
ECommerce_Site/
├── app/
│   ├── Console/
│   ├── Http/
│   ├── Models/
│   └── Providers/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
└── public/
```

## 🔐 Seguridad

-   Sistema de autenticación de Laravel
-   Protección CSRF
-   Encriptación segura de contraseñas
-   Control de acceso basado en roles
-   Validación de formularios

## 🧪 Pruebas

```bash
php artisan test
```

## 📝 Rutas de la API

### Productos

-   GET /products - Obtener todos los productos
-   GET /products/{id} - Obtener producto específico
-   POST /products - Crear nuevo producto (Admin)
-   PUT /products/{id} - Actualizar producto (Admin)
-   DELETE /products/{id} - Eliminar producto (Admin)

### Usuarios

-   POST /register - Registro de usuario
-   POST /login - Inicio de sesión
-   GET /profile - Obtener perfil de usuario

### Pedidos

-   POST /orders - Crear pedido
-   GET /orders - Obtener pedidos del usuario
-   GET /orders/{id} - Obtener pedido específico

## 👥 Contribuir

Las contribuciones son bienvenidas. Sigue estos pasos:

1. Haz un fork del proyecto
2. Crea tu rama de características
3. Realiza tus cambios
4. Envía tus cambios
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT.

## 📞 Soporte

Para soporte o preguntas, por favor abre un issue en el repositorio.

---

⌨️ con ❤️ por [Michael Vairo]
