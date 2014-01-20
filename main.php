<?php
class WC_Catalog_Products 
{
	function __construct()
	{
		add_action( 'woocommerce_init', array(&$this,'woocommerce_init'));
		
	}
	function woocommerce_init()
	{
	$enabled = get_option('enable_catalog');
	if(isset($enabled) && $enabled == 'yes')
	{
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_variable_product_summary', 'woocommerce_template_variable_price', 10 );
    remove_action( 'woocommerce_variable_product_summary', 'woocommerce_template_variable_add_to_cart', 30 );
    remove_action( 'woocommerce_external_product_summary', 'woocommerce_template_external_price', 10 );
    remove_action( 'woocommerce_external_product_summary', 'woocommerce_template_external_add_to_cart', 30 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );	
    add_action('woocommerce_single_product_summary',array(&$this,'change_text'));
    add_action('woocommerce_template_single_price',array(&$this,'change_text'));
    add_action('woocommerce_variable_product_summary',array(&$this,'change_text'));
    add_action('woocommerce_template_variable_price',array(&$this,'change_text'));
    add_action('woocommerce_external_product_summary',array(&$this,'change_text'));
    add_action('woocommerce_template_external_price',array(&$this,'change_text'));
    add_action( 'woocommerce_after_shop_loop_item',array(&$this,'change_text'));
	}
    add_filter( 'woocommerce_catalog_settings', array(&$this,'woocommerce_catalog_settings' ));

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this,'action_links'));




	}
	
public function action_links( $links ) {
   $links[] = '<a href="'. get_admin_url(null, 'page=woocommerce_settings&tab=catalog') .'">Catalog Settings</a>';
   return $links;
}
 
public function change_text()
{
	global $post_id;
	$link = get_permalink( $post_id ); 
	$call_to_action = get_option('catalog_call_to_action');
?>
<a href='<?=@$link;?>' class='btn btn-primary catalog-product'><?=@$call_to_action?></a>
<?php

}
public function woocommerce_catalog_settings( $settings ) {



  $updated_settings = array();



  foreach ( $settings as $section ) {



    // at the bottom of the General Options section

    if ( isset( $section['id'] ) && 'catalog_options' == $section['id'] &&

       isset( $section['type'] ) && 'sectionend' == $section['type'] ) {



 $updated_settings[] = array(

        'name'     => __( 'Enable product catalog', 'catalog_call_to_action' ),

        'desc_tip' => __( '', 'wc_seq_order_numbers' ),

        'id'       => 'enable_catalog',

        'type'     => 'checkbox',

        'css'      => 'min-width:20px;',

        'std'      => '1',  // WC < 2.0

        'default'  => '1',  // WC >= 2.0

        'desc'     => 'This will enable or disable product cataloging products'

      );
      
      

      $updated_settings[] = array(

        'name'     => __( 'Catalog call to action', 'catalog_call_to_action' ),

        'desc_tip' => __( 'This will used as the call to action on all products', 'wc_seq_order_numbers' ),

        'id'       => 'catalog_call_to_action',

        'type'     => 'text',

        'css'      => 'min-width:300px;',

        'std'      => '1',  // WC < 2.0

        'default'  => '1',  // WC >= 2.0

        'desc'     => 'example : Call for pricing  1-888-555-5555'

      );

    }



    $updated_settings[] = $section;

  }

  return $updated_settings;

}
}
new WC_Catalog_Products;
?>