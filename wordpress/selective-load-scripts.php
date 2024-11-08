<?php

/**
 * Snippet para mejorar el rendimiento en WordPress desactivando plugins
 * y cargando scripts solo en las páginas donde se necesitan.
 * 
 * Este código es útil para sitios que utilizan WooCommerce o similares,
 * donde algunos plugins y scripts son necesarios únicamente en ciertas
 * secciones específicas.
 */

// FILTRO PARA DESACTIVAR PLUGINS EN PÁGINAS ESPECÍFICAS

// Agrega el filtro 'option_active_plugins' que modifica la lista de plugins activos
add_filter('option_active_plugins', 'conditional_plugin_loader');

/**
 * Desactiva plugins específicos fuera de las páginas de WooCommerce donde se requieren.
 *
 * Este filtro permite que solo se carguen ciertos plugins en las páginas donde son necesarios,
 * lo que mejora el rendimiento del sitio al reducir la carga de plugins en otras secciones.
 *
 * @param array $plugins Lista actual de plugins activos.
 * @return array Lista de plugins filtrada, desactivando algunos en páginas no permitidas.
 */
function conditional_plugin_loader($plugins)
{
	// Define las páginas permitidas (condicionales de WooCommerce)
	$allowed_pages = [
		'is_product',    // Página de producto
		'is_cart',       // Página del carrito
		'is_checkout'    // Página de checkout
	];

	// Verifica si la página actual es una de las páginas permitidas
	$is_allowed = false;
	foreach ($allowed_pages as $allowed_page) {
		if (function_exists($allowed_page) && $allowed_page()) {
			$is_allowed = true;
			break;
		}
	}

	// Si no estamos en una página permitida, desactiva los plugins especificados
	if (!$is_allowed) {
		$plugins_to_disable = [
			'woocommerce-mercadopago/woocommerce-mercadopago.php', // Plugin de pago MercadoPago
			'woo-currency-switcher/woo-currency-switcher.php',     // Plugin de cambio de moneda
			'woo-payment-gateway/woo-payment-gateway.php'          // Otro plugin de gateway de pago
		];

		foreach ($plugins_to_disable as $plugin) {
			$key = array_search($plugin, $plugins);
			if ($key !== false) {
				unset($plugins[$key]); // Remueve el plugin de la lista activa
			}
		}
	}

	// Retorna la lista filtrada de plugins
	return $plugins;
}

// CARGA SELECTIVA DE SCRIPTS EN PÁGINAS ESPECÍFICAS

// Agrega la acción 'wp_enqueue_scripts' para cargar scripts condicionalmente
add_action('wp_enqueue_scripts', 'load_cart_scripts');

/**
 * Encola scripts solo en la página del carrito para mejorar el rendimiento.
 *
 * Este método usa la función `is_cart()` de WooCommerce para verificar si la página actual
 * es la del carrito y encolar un script solo en esa página específica.
 */
function load_cart_scripts()
{
	// Condición: Solo encola el script en la página del carrito de WooCommerce
	if (is_cart()) {
		wp_enqueue_script(
			'cart-custom-script',                        // Identificador único del script
			get_template_directory_uri() . '/js/cart-custom.js', // Ruta al script en el tema
			array('jquery'),                             // Dependencia de jQuery
			'1.0',                                       // Versión del script
			true                                         // Carga en el footer
		);
	}
}
