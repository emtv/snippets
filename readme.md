# 🚀 Snippets de Desarrollo

¡Bienvenido al repositorio de **Snippets de Desarrollo**! Aquí encontrarás una colección cuidadosamente seleccionada de **snippets de código** para optimizar y facilitar diversas tareas de desarrollo en tecnologías como **WordPress, JavaScript, SQL, PHP**, entre otros. Este repositorio es un recurso en constante evolución, creado para mejorar la eficiencia y el rendimiento en proyectos reales.

## 📂 Estructura del Repositorio

La organización sigue una estructura lógica por categorías y tecnologías, permitiendo que desarrolladores encuentren rápidamente lo que necesitan. Cada snippet está documentado para explicar su propósito, uso y beneficios. Aquí tienes una vista general de la estructura:

snippets/
├── wordpress/
│   └── selective-load-scripts.php   # Carga selectiva de scripts y plugins en WordPress
├── javascript/
│   └── example-snippet.js           # Ejemplos de código JavaScript
├── sql/
│   └── example-query.sql            # Ejemplos de consultas SQL
└── php/
    └── example-php-snippet.php      # Ejemplos de código PHP



> **Nota:** Este repositorio se actualizará regularmente con nuevos snippets y mejoras en el código existente, basadas en la experiencia y necesidades surgidas en proyectos en desarrollo.

## 🌟 Ejemplo Destacado: Carga Selectiva de Scripts y Plugins en WordPress

Uno de los ejemplos más destacados en este repositorio es el archivo `selective-load-scripts.php`, que se centra en optimizar el rendimiento de sitios **WordPress** al desactivar plugins y cargar scripts únicamente en las páginas donde realmente se necesitan. Esto es particularmente útil en sitios con WooCommerce o similares, donde algunos plugins y scripts solo son necesarios en ciertas secciones.

### 💡 ¿Qué Hace Este Snippet?

El snippet `selective-load-scripts.php` incluye dos funcionalidades clave:

1. **Desactivación de plugins en páginas específicas:** Mejora el rendimiento de WordPress al desactivar ciertos plugins en páginas donde no son requeridos.
2. **Carga condicional de scripts en WooCommerce:** Encola scripts solo en páginas específicas (por ejemplo, el carrito de compras), reduciendo la carga de recursos en el resto del sitio.

#### Código de Ejemplo

```php
<?php
// Este ejemplo desactiva plugins fuera de las páginas de WooCommerce y carga un script solo en la página del carrito.

add_filter('option_active_plugins', 'conditional_plugin_loader');
function conditional_plugin_loader($plugins) {
    $allowed_pages = ['is_product', 'is_cart', 'is_checkout'];
    $is_allowed = false;
    foreach ($allowed_pages as $allowed_page) {
        if (function_exists($allowed_page) && $allowed_page()) {
            $is_allowed = true;
            break;
        }
    }

    if (!$is_allowed) {
        $plugins_to_disable = [
            'woocommerce-mercadopago/woocommerce-mercadopago.php',
            'woo-currency-switcher/woo-currency-switcher.php',
        ];
        foreach ($plugins_to_disable as $plugin) {
            $key = array_search($plugin, $plugins);
            if ($key !== false) {
                unset($plugins[$key]);
            }
        }
    }
    return $plugins;
}


## 🛠 Herramientas y Recomendaciones
Algunos de los snippets aquí están optimizados para proyectos que requieren un alto rendimiento o una carga eficiente de recursos. Utilizamos tecnologías modernas y técnicas de optimización, asegurando compatibilidad y eficiencia en entornos de producción.

## 📜 Licencia
Este repositorio se distribuye bajo la Licencia MIT, lo que permite su uso en proyectos personales y comerciales, siempre que se proporcione la atribución adecuada.

## 💡 Mantente atento a futuras actualizaciones: A medida que nuevos retos surgen, se irán agregando más snippets y mejoras a este repositorio. ¡Esperamos que este recurso sea de ayuda en tus proyectos!