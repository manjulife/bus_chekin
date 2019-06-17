<?php 
    get_header(); 
    the_post();
    global $post, $woocommerce;
    $bus_meta           = get_post_custom(get_the_id());
    // $seat_col           = $bus_meta['wbbm_seat_col'][0];
    // $seat_row           = $bus_meta['wbbm_seat_row'][0];
    $next_stops_arr     = get_post_meta(get_the_id(), 'wbbm_bus_next_stops', true);
    $wbbm_bus_bp_stops  = get_post_meta(get_the_id(), 'wbbm_bus_bp_stops', true);
    // $seat_col_arr       = explode(",",$seat_col);
    // $seat_row_arr       = explode(",",$seat_row);
    // $seat_column        = count($seat_col_arr);
    $count              = 1;
    // $fare   = $bus_meta['wbbm_bus_route_fare'][0];

    $start  = isset( $_GET['bus_start_route'] ) ? sanitize_text_field($_GET['bus_start_route']) : '';
    $end    = isset( $_GET['bus_end_route'] ) ? sanitize_text_field($_GET['bus_end_route']) : '';
    $date   = isset( $_GET['j_date'] ) ? sanitize_text_field($_GET['j_date']) : date('Y-m-d');
    $term = get_the_terms(get_the_id(),'wbbm_bus_cat');
    $price_arr = get_post_meta(get_the_id(),'wbbm_bus_prices',true);  
?>
    <div class="wbbm-content-wrapper">
        <?php do_action( 'woocommerce_before_single_product' ); ?>
        <div class="bus-details">
            <div class="bus-thumbnail">
                <?php the_post_thumbnail('full'); ?>
            </div>
            <div class="bus-details-info">
                <h2><?php the_title(); ?></h2>
                <h3><?php if(isset($term[0]->name)){ echo $term[0]->name; } ?></h3>
                <?php the_content(); ?>
                <p><strong>

                <?php echo wbbm_get_option('wbbm_bus_no_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_bus_no_text', 'wbbm_label_setting_sec') : _e('Bus No:','bus-booking-manager'); ?>

                </strong> <?php echo get_post_meta(get_the_id(),'wbbm_bus_no',true); ?></p>
                <p><strong>

                <?php echo wbbm_get_option('wbbm_total_seat_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_total_seat_text', 'wbbm_label_setting_sec') : _e('Total Seat:','bus-booking-manager'); ?>
                    
                </strong> <?php echo get_post_meta(get_the_id(),'wbbm_total_seat',true); ?> </p>
                <div class="bus-route-details">
                    <div class="bus-route-list">
                        <h6>
                         <?php echo wbbm_get_option('wbbm_boarding_points_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_boarding_points_text', 'wbbm_label_setting_sec') : _e('Boarding Ponints','bus-booking-manager'); ?>
                        </h6>
                        <ul>
                            <?php
                            $start_stops = get_post_meta(get_the_id(),'wbbm_bus_bp_stops',true);
                            
                            foreach ($start_stops as $_start_stops) {
                                # code...
                                echo "<li>".$_start_stops['wbbm_bus_bp_stops_name']."</li>";
                            }
                            ?>                            
                        </ul>
                    </div>
                    <div class="bus-route-list">
                        <h6>
                         <?php echo wbbm_get_option('wbbm_dropping_points_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_dropping_points_text', 'wbbm_label_setting_sec') : _e('Dropping Ponints','bus-booking-manager'); ?>   
                        </h6>
                        <ul>
                            <?php
                            $end_stops = get_post_meta(get_the_id(),'wbbm_bus_next_stops',true);
                            foreach ($end_stops as $_end_stops) {
                                echo "<li>".$_end_stops['wbbm_bus_next_stops_name']."</li>";
                            }
                            ?>                            
                        </ul>                        
                    </div>
                </div>
            </div>
        </div>
<div class="bus-single-search-form">
<form action="" method="get">
    <?php 
    if(isset($_GET['bus_start_route'])){
        $bus_start = strip_tags($_GET['bus_start_route']);
    }else{
        $bus_start = "";
    }
    if(isset($_GET['bus_end_route'])){
        $bus_end = strip_tags($_GET['bus_end_route']);
    }else{
        $bus_end = "";
    }
    ?>
    <ul class="search-li">
        <li>
            <label for="boarding_point">
                 <?php echo wbbm_get_option('wbbm_boarding_points_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_boarding_points_text', 'wbbm_label_setting_sec') : _e('Boarding Ponints','bus-booking-manager'); ?>
                    <select name="bus_start_route" id="boarding_point" required>
                            <option value=""><?php _e('Select Boarding Point','bus-booking-manager'); ?></option>
                        <?php 
                            foreach ($start_stops as $_start_stops) {
                                ?>
                                <option name="<?php echo $brs = $_start_stops['wbbm_bus_bp_stops_name']; ?>" <?php if($brs==$bus_start){ echo 'selected'; } ?>><?php echo $_start_stops['wbbm_bus_bp_stops_name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
            </label>            
        </li>
        <li>
            <label for="drp_point">
                <?php echo wbbm_get_option('wbbm_dropping_points_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_dropping_points_text', 'wbbm_label_setting_sec') : _e('Dropping Ponints','bus-booking-manager'); ?>
                    <select name="bus_end_route" id="drp_point" required>
                        <option value=""><?php _e('Select Droping Point','bus-booking-manager'); ?></option>
                        <?php 
                            foreach ($end_stops as $_end_stops) {
                                ?>
                                <option name="<?php echo $brd = $_end_stops['wbbm_bus_next_stops_name']; ?>" <?php if($brd==$bus_end){ echo 'selected'; } ?>><?php echo $_end_stops['wbbm_bus_next_stops_name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
            </label>              
        </li>
        <li>
            <label for="j_date">
                <?php echo wbbm_get_option('wbbm_select_journey_date_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_select_journey_date_text', 'wbbm_label_setting_sec') : _e('Select Journey Date','bus-booking-manager'); ?>
                <input type="text" id='j_date' name='j_date' class="text" value='<?php echo date('Y-m-d'); ?>' required>
            </label>
        </li>
        <li>
            <button type="submit">
            <?php echo wbbm_get_option('wbbm_search_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_search_text', 'wbbm_label_setting_sec') : _e('Search','bus-booking-manager'); ?>
            </button>
        </li>
    </ul>
    </form>    
</div>
    <?php if( isset( $_GET['j_date'] ) ) { ?>
    <div class="bus-info-sec">
<?php 
$price_arr = get_post_meta(get_the_id(),'wbbm_bus_prices',true);
$fare = wbbm_get_bus_price($start,$end, $price_arr);
    $values         = get_post_custom( get_the_id() );
    $term           = get_the_terms(get_the_id(),'wbbm_bus_cat');
    $total_seat     = $values['wbbm_total_seat'][0];
    $sold_seat      = wbbm_get_available_seat(get_the_id(),$date);
    $available_seat = ($total_seat - $sold_seat);
    $price_arr      = get_post_meta(get_the_id(),'wbbm_bus_prices',true);   
    $bus_bp_array   = get_post_meta(get_the_id(),'wbbm_bus_bp_stops',true);
    $bus_dp_array   = get_post_meta(get_the_id(),'wbbm_bus_next_stops',true);   
    $bp_time        = wbbm_get_bus_start_time($end, $bus_bp_array);
    $dp_time        = wbbm_get_bus_end_time($start, $bus_dp_array);
?>
            <form action="" method='post'>
                <div class="top-search-section">
                   <div class="leaving-list">
                    <h6><?php echo wbbm_get_option('wbbm_total_passenger_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_total_passenger_text', 'wbbm_label_setting_sec') : _e('Total Passenger:','bus-booking-manager');  ?></h6>
                    <?php wbbm_seat_form($start,$end, $price_arr); ?>       
                   </div> 
                    <div class="leaving-list">
                         <input type="hidden"  name='journey_date' class="text" value='<?php echo $date; ?>'>
                        <input type="hidden" name='start_stops' value="<?php echo $start; ?>" class="hidden">
                        <input type="hidden" id='bus_id' name="bus_id" value="<?php echo get_the_id(); ?>">
                        <h6><?php echo wbbm_get_option('wbbm_route_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_route_text', 'wbbm_label_setting_sec') : _e('Route','bus-booking-manager');?>   </h6>
                        
                        <div class="selected_routes">
                            <?php printf( '<span>%s <i class="fa fa-long-arrow-right"></i> %s<span>', $start, $end ); ?>
                            <input type='hidden' value='<?php echo $end; ?>' name='end_stops'/> <!-- (<?php echo get_woocommerce_currency_symbol(); ?><?php echo wbbm_get_bus_price($start,$end, $price_arr); ?>) -->
                        </div>
                    </div>                    
                    <div class="leaving-list">
                        <h6>
                          <?php echo wbbm_get_option('wbbm_date_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_date_text', 'wbbm_label_setting_sec') : _e('Date','bus-booking-manager');?>  

                        </h6>
                        <div class="selected_date">
                            <?php printf( '<span>%s</span>', date( 'jS F, Y', strtotime( $date ) ) ); ?>
                        </div>
                    </div>   

                    <div class="leaving-list">
                        <h6>
                         <?php echo wbbm_get_option('wbbm_start_arrival_time_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_start_arrival_time_text', 'wbbm_label_setting_sec') : _e('Start & Arrival Time','bus-booking-manager');
                         ?> 
                        </h6>

                        <div class="selected_date">
                            <?php  
                                $bus_bp_array = get_post_meta(get_the_id(),'wbbm_bus_bp_stops',true);
                                $bus_dp_array = get_post_meta(get_the_id(),'wbbm_bus_next_stops',true);
                                $bp_time = wbbm_get_bus_start_time($start, $bus_bp_array);
                                $dp_time = wbbm_get_bus_end_time($end, $bus_dp_array);
                                echo date('h:i A', strtotime($bp_time)).' <i class="fa fa-long-arrow-right"></i> '.date('h:i A', strtotime($dp_time));
                            ?>
                        <input type="hidden" value="<?php echo date('h:i A', strtotime($bp_time)); ?>" name="user_start_time" id='user_start_time'>
                        <input type="hidden" name="bus_start_time" value="<?php echo date('h:i A', strtotime($bp_time)); ?>" id='bus_start_time'>                            
                        </div>
                    </div>
                    <div class="leaving-list">
                        <button id='bus-booking-btn' type="submit" name="add-to-cart" value="<?php echo esc_attr(get_the_id()); ?>" class="single_add_to_cart_button button alt btn-mep-event-cart">
                       
                       <?php echo wbbm_get_option('wbbm_book_now_text', 'wbbm_label_setting_sec') ? wbbm_get_option('wbbm_book_now_text', 'wbbm_label_setting_sec') : _e('Book Now','bus-booking-manager');
                         ?>    
                        </button>
                    </div>                                       
                </div>
                <div class="wbbm-passenger">
                    <div class='passengger-list' id="divParent_<?php echo get_the_id(); ?>"></div>
                    <div class='passengger-list' id="divParent_child_<?php echo get_the_id(); ?>"></div>
                </div>               
            </form>
        </div>

    <?php } ?>
</div>
</div>
<script>

jQuery('#quantity_<?php echo get_the_id(); ?>').on('change', function () {
        var input       = jQuery(this).val() || 0;
        var children    = jQuery('#divParent_<?php echo get_the_id(); ?> > div').size() || 0;
        if (input < children) {
            jQuery('#divParent_<?php echo get_the_id(); ?>').empty();
            children = 0;
        }
        for (var i = children + 1; i <= input; i++) {
            jQuery('#divParent_<?php echo get_the_id(); ?>').append(
                jQuery('<div/>')
                .attr("id", "newDiv" + i)
                .html("<?php do_action('wbbm_reg_fields'); ?>")
            );
        }
});


jQuery('#child_quantity_<?php echo get_the_id(); ?>').on('change', function () {
        var input       = jQuery(this).val() || 0;
        var children    = jQuery('#divParent_child_<?php echo get_the_id(); ?> > div').size() || 0;
        if (input < children) {
            jQuery('#divParent_child_<?php echo get_the_id(); ?>').empty();
            children = 0;
        }
        for (var i = children + 1; i <= input; i++) {
            jQuery('#divParent_child_<?php echo get_the_id(); ?>').append(
                jQuery('<div/>')
                .attr("id", "newDiv" + i)
                .html("<?php do_action('wbbm_reg_fields_child'); ?>")
            );
        }
});



// jQuery('.bqty').on('change', function() {
//     var sum = 0;
//     jQuery(".bqty").each(function(){
//         sum += +jQuery(this).val();
//     });
//     var children    = jQuery('#divParent_<?php echo get_the_id(); ?> > div').size() || 0;
//     if (sum < children) {
//         jQuery('#divParent_<?php echo get_the_id(); ?>').empty();
//         children = 0;
//     }
//         for (var i = children + 1; i <= sum; i++) {
//             jQuery('#divParent_<?php echo get_the_id(); ?>').append(
//                 jQuery('<div/>')
//                 .attr("id", "newDiv" + i)
//                 .html("<?php do_action('wbbm_reg_fields'); ?>")
//             );
//         }    
// });
</script>
<?php get_footer(); ?>