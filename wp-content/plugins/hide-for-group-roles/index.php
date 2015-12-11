<?php
/*
Plugin Name: Hide for group (roles)
Plugin URI: http://www.kuaza.com
Description: Wordpress Hide for group (roles): page, post (or text), category, tags,tax v.s..
Author: kuaza
Version: 1.0
Author URI: http://www.kuaza.com
*/

// gelistirici icindir: hatalari gormek icin (varsa) :)
// error_reporting(E_ALL); ini_set("display_errors", 1);

if ( ! defined( 'ABSPATH' ) ) exit; 

define( 'K_GROUP_VER', '1.0' );
define( 'K_GROUP_URI', plugin_dir_url( __FILE__ ) );
define( 'K_GROUP_DIR', plugin_dir_path( __FILE__ ) );
define( 'K_GROUP_PLUGIN', __FILE__ );
define( 'K_GROUP_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );

add_action( 'plugins_loaded', 'kgroup_textdomain' );
function kgroup_textdomain() {
	load_plugin_textdomain("k_group", false, K_GROUP_DIRNAME.'/languages/');
}

		global $current_user;
			//Fix: http://david-coombes.com/wordpress-get-current-user-before-plugins-loaded/
			if(!function_exists('wp_get_current_user'))
				require_once(ABSPATH . "wp-includes/pluggable.php"); 
				
			wp_cookie_constants();
			$current_user = $user = wp_get_current_user();
		
			$user_roles = $current_user->roles;

			$kullanici_level = array_shift($user_roles);
			$kullanici_level = (empty($kullanici_level) ? "ziyaretci" : $kullanici_level);

			$izinli_gruplar_eklenti = unserialize(get_option("yetkili_kullanici_rolleri"));
	
			if ( $kullanici_level == "administrator" || (is_array($izinli_gruplar_eklenti) && in_array($kullanici_level,$izinli_gruplar_eklenti)) ) {
			add_action( 'add_meta_boxes', 'k_group_add_meta_box' );
			add_action( 'save_post', 'k_group_save_meta_options' );
			}
			
		// kullanici grubu siteyi gorup gormeme yetkisine bakariz.
		$siteyetki_gruplar_eklenti = unserialize(get_option("sitekimlergorsun_kullanici_rolleri"));
			
		if($kullanici_level != "administrator" && !is_login_page()){	
			if ( (is_array($siteyetki_gruplar_eklenti) && !in_array($kullanici_level,$siteyetki_gruplar_eklenti)) ) {
				add_action('init', 'k_group_sitekapali');
			}
		}
		
		function k_group_sitekapali(){
				// yonlendirilecek sayfa linki
				
			$yonlenecek = get_option("gizli_icerik_yonlendirme_linki");
		
			if(!sayfa_kontrol($yonlenecek)){
			wp_redirect( ($yonlenecek ? $yonlenecek : home_url()) );
	
			return exit;
			}
	
		}			
			
			
	// giris yada kayit sayfasi olup olmadigina bakar.
	// http://stackoverflow.com/a/5892694/2824532
	function is_login_page() {
		return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	}			

	// sayfa linkinin verilen deger ile ayni olup olmadigina bakar
	// sonuc ayni ise true, farkli ise false doner..
	function sayfa_kontrol($yonlenecek = '') {

		$sayfa_adresi = "".str_replace("www.","",$_SERVER['HTTP_HOST'])."".$_SERVER['REQUEST_URI']."";
		
		// yonlendirilecek sayfa linki
		if(empty($yonlenecek))
		$yonlenecek = get_option("gizli_icerik_yonlendirme_linki");
		
		$gizli_icerik_yonlendir = str_replace("http://","",str_replace("www.","",$yonlenecek)); 
		
		//echo $sayfa_adresi." - ".$yonlenecek;
		
		if($gizli_icerik_yonlendir != $sayfa_adresi)
		return false;
		
		return true;

	}
	
	/*
	* Kullanici rollerine gore gizleme yapar
	* Yazi icinde belli bolumleri gizlemeye yarar
	*/		
	function khide_shortcode( $atts, $content = null ) {
	global $kullanici_level;

		// gruplari explode eder arraya donustururuz
		if(isset($atts["allowed_group"]) && !empty($atts["allowed_group"])){
		$izinli_gruplar = explode(",",$atts["allowed_group"]);

			// grup belirtilmemis ise default gruplari aliriz.
			}else{

			 // default izinli gruplar
			 $izinli_gruplar = unserialize(get_option("eskiler_kullanici_rolleri"));
			 
			}

		// eger gormeyi hakediyorsa
		if(($kullanici_level == "administrator" || in_array($kullanici_level,$izinli_gruplar))){
		
		return '<span class="k_hide_show">' . $content . '</span>';

			// gormeyi haketmiyorsa gizlilik mesaji cikar
			}else{
			
				// gizlilik mesaji varsa
				if(isset($atts["message"]) && !empty($atts["message"])){
				
				return $atts["message"];
				
					// gizlilik mesaji yoksa defaultu cekeriz
					}else{
					
					$gizli_icerik_uyari = get_option("gizli_icerik_uyari"); 
			 
					return $gizli_icerik_uyari ? stripslashes($gizli_icerik_uyari) : __("In order to see this content you need to upgrade your membership.","k_group");
					}
			}
	}
	add_shortcode( 'k_hide', 'khide_shortcode' );			
	
/*
tekil sayfada yetkili olup olmadigi kontrol edilir, degil ise uyelik sayfasina yonlendirilir.
yetkili ise herhangi bir islem yapilmaz.
*/
function tekil_sayfa_ve_kontrol()
{
global $kullanici_level;
	
	// uye grubu yetki kontrolu
    if (is_singular()){
		global $post;
		
		$eskiler_iptalmi = get_option("eskiler_iptalmi"); 
		 			
		//iptalmi kontrol edelim
		$iptalmi = get_post_meta( $post->ID, '_k_group_iptalet', true );
		$iptalmi = (!empty($iptalmi) ? $iptalmi : (!empty($eskiler_iptalmi) ? $eskiler_iptalmi : "iptal_et"));
				
		if($iptalmi == "iptal_et")
		return;
		
		$izinli_gruplar = get_post_meta( $post->ID, '_k_group_izinli_gruplar', true );
		$izinli_gruplar = (!empty($izinli_gruplar) ? unserialize($izinli_gruplar) : unserialize(get_option("eskiler_kullanici_rolleri")));
		
			if(($kullanici_level == "administrator" || in_array($kullanici_level,$izinli_gruplar))){
			
			// gormeye hak kazandi :)
			return;
			
			}else{ //gecemedin	
			
				$gizli_icerik_yonlendir = get_option("gizli_icerik_yonlendirme_linki"); 
				
				// adminden belirlenen sayfaya yonlendirilir.
				wp_redirect( ($gizli_icerik_yonlendir ? $gizli_icerik_yonlendir : home_url()) );
				
				return exit;
			}

		return;

	// kategori sayfalari icin kontrol alani
	}elseif (is_category()){
	
		$queried_object = get_queried_object();
		//kategori id alma
		$kategori_id = $queried_object->term_id;
		$eskiler_iptalmi = get_option("eskiler_iptalmi"); 
		 	
		//iptalmi kontrol edelim
		$iptalmi = get_term_meta($kategori_id, 'meta_kullanici_rolleri_iptalmi', true);
		$iptalmi = (!empty($iptalmi) ? $iptalmi : (!empty($eskiler_iptalmi) ? $eskiler_iptalmi : "iptal_et"));
				
		if($iptalmi == "iptal_et")
		return;
		
			$kategori_user_rolleri = unserialize(get_term_meta($kategori_id, 'meta_kullanici_rolleri', true));
			$kategori_user_rolleri = (isset($kategori_user_rolleri) || is_array($kategori_user_rolleri) ? $kategori_user_rolleri : unserialize(get_option("eskiler_kullanici_rolleri")));
			
			if(($kullanici_level == "administrator" || in_array($kullanici_level,$kategori_user_rolleri))){
			
			// gormeye hak kazandi :)
			return;
			
			}else{ //gecemedin	
			
				$gizli_tax_yonlendir = get_option("gizli_tax_yonlendirme_linki"); 
				
				// adminden belirlenen sayfaya yonlendirilir.
				wp_redirect( ($gizli_tax_yonlendir ? $gizli_tax_yonlendir : home_url()) );
				
				return exit;
			}

		return;
	
	// tag sayfalari icin kontrol alani
	}elseif (is_tag()){

		$queried_object = get_queried_object();
		
		//etiket id alma
		$etiket_id = $queried_object->term_id;
		
		$eskiler_iptalmi = get_option("eskiler_iptalmi"); 
		 		
		//iptalmi kontrol edelim
		$iptalmi = get_term_meta($etiket_id, 'meta_kullanici_rolleri_iptalmi', true);
		$iptalmi = (!empty($iptalmi) ? $iptalmi : (!empty($eskiler_iptalmi) ? $eskiler_iptalmi : "iptal_et"));
		
		if($iptalmi == "iptal_et")
		return $content;
		
			$etiket_user_rolleri = unserialize(get_term_meta($etiket_id, 'meta_kullanici_rolleri', true));
			$etiket_user_rolleri = (isset($etiket_user_rolleri) || is_array($etiket_user_rolleri) ? $etiket_user_rolleri : unserialize(get_option("eskiler_kullanici_rolleri")));
			
			if(($kullanici_level == "administrator" || in_array($kullanici_level,$etiket_user_rolleri))){
			
			// gormeye hak kazandi :)
			return;
			
			}else{ //gecemedin	
			
				$gizli_tax_yonlendir = get_option("gizli_tax_yonlendirme_linki"); 
				
				// adminden belirlenen sayfaya yonlendirilir.
				wp_redirect( ($gizli_tax_yonlendir ? $gizli_tax_yonlendir : home_url()) );
				
				return exit;
			}
		
		return;
	
	}else{

	return;
	}
   
}
add_action( 'wp', 'tekil_sayfa_ve_kontrol' );

	/**
	 * tekil sayfa olmayan bolumlerde aciklama ve yazi kismini gizler.
	 * @public
	 */		
	function k_group_aciklama_gizle($content){
		global $post, $kullanici_level;
		
		$eskiler_iptalmi = get_option("eskiler_iptalmi"); 
		 
		//iptalmi kontrol edelim
		$iptalmi = get_post_meta( $post->ID, '_k_group_iptalet', true );
		$iptalmi = (!empty($iptalmi) ? $iptalmi : (!empty($eskiler_iptalmi) ? $eskiler_iptalmi : "iptal_et"));
		
		if($iptalmi == "iptal_et")
		return $content;
		
		$izinli_gruplar = get_post_meta( $post->ID, '_k_group_izinli_gruplar', true );
		$izinli_gruplar = (!empty($izinli_gruplar) ? unserialize($izinli_gruplar) : unserialize(get_option("eskiler_kullanici_rolleri")));

		if($kullanici_level == "administrator" || in_array($kullanici_level,$izinli_gruplar)){
		
		return $content;
		
		}else{
		 $gizli_icerik_uyari = get_option("gizli_icerik_uyari"); 
 
		return $gizli_icerik_uyari ? stripslashes($gizli_icerik_uyari) : __("In order to see this content you need to upgrade your membership.","k_group");
		}

	}
	// yazi aciklamasini gizleme
	add_filter('the_content', 'k_group_aciklama_gizle');
	add_filter('get_the_excerpt', 'k_group_aciklama_gizle');
		
 
function k_group_sayfa_head(){
return true;
}

function k_group_ilk_sayfa() {
	$k_groupsayfa = add_posts_page('WP K_hide', 'WP K_hide', 8, 'k_group', 'k_group_ilk');
	add_action("admin_head-$k_groupsayfa", 'k_group_sayfa_head');
}
add_action('admin_menu', 'k_group_ilk_sayfa');

function k_group_ilk(){
$islem = (!empty($_GET['islem']) ? $_GET['islem'] : "");
?>
<div class="wrap">
<h2><?php echo __("Wordpress hide post, category, tags...","k_group"); ?> - <a href="http://kuaza.com" target="_blank">Kuaza</a> Saygıyla sunar..</h2>
<?php
switch($islem):
	case 'ekle':
	// next version :)
	break;

	default;
		k_group_index_sayfasi();
	break;
endswitch;
?>
</div>
<?php
}

function k_group_index_sayfasi(){
 global $wp_roles;

if($_POST && !empty($_POST)){
 // kullanici rollerini cekeriz
 $default_kullanici_rolleri = get_option("default_kullanici_rolleri");
 
 //yetkili kullanici rollerini cekeriz
 $yetkili_kullanici_rolleri = get_option("yetkili_kullanici_rolleri");
 
 //eski yazilar icin gorebilecek default gruplar
 $eskiler_kullanici_rolleri = get_option("eskiler_kullanici_rolleri"); 
 
 //siteyi kimler gorebilir?
 $sitekimlergorsun_kullanici_rolleri = get_option("sitekimlergorsun_kullanici_rolleri");  
 
 //ayarlardan uyari metnini cekeriz
 $gizli_icerik_uyari = get_option("gizli_icerik_uyari"); 

$default_kullanici_rolleri_y = array();
$yetkili_kullanici_rolleri_y = array();
$eskiler_kullanici_rolleri_y = array();
$sitekimlergorsun_kullanici_rolleri_y = array();
foreach ( $wp_roles->roles as $key=>$value ):

/*default */
if(isset($_POST[$key]) && $_POST[$key] == $key){

$default_kullanici_rolleri_y[] = $key;

}

/* yetkili */
if(isset($_POST["yetkili_".$key]) && $_POST["yetkili_".$key] == "yetkili_".$key){

$yetkili_kullanici_rolleri_y[] = $key;

}

/* siteyi kimler gorebilir */
if(isset($_POST["sitekimlergorsun_".$key]) && $_POST["sitekimlergorsun_".$key] == "sitekimlergorsun_".$key){

$sitekimlergorsun_kullanici_rolleri_y[] = $key;

}

/* eskiler */
if(isset($_POST["eskiler_".$key]) && $_POST["eskiler_".$key] == "eskiler_".$key){

$eskiler_kullanici_rolleri_y[] = $key;

}

/* silgitsin */
if(isset($_POST["silgitsin_".$key]) && $_POST["silgitsin_".$key] == "silgitsin_".$key){

if($key == "administrator" || $key == "editor" || $key == "author" || $key == "contributor" || $key == "subscriber"){
// default rolleri ellettirmem aga :D
}else{
remove_role( $key );
}

}

endforeach;

// ziyaretciyi default icin ekleme alani
if(isset($_POST["ziyaretci"])){
$default_kullanici_rolleri_y[] = "ziyaretci";
}

// ziyaretciyi eskiler icin ekleme alani
if(isset($_POST["eskiler_ziyaretci"])){
$eskiler_kullanici_rolleri_y[] = "ziyaretci";
}


// default gruplari options a ekleme
if(isset($default_kullanici_rolleri)){
update_option("default_kullanici_rolleri",serialize($default_kullanici_rolleri_y));
}else{
add_option("default_kullanici_rolleri",serialize($default_kullanici_rolleri_y));
}

// yetkili gruplari optionsa ekleme
if(isset($yetkili_kullanici_rolleri)){
update_option("yetkili_kullanici_rolleri",serialize($yetkili_kullanici_rolleri_y));
}else{
add_option("yetkili_kullanici_rolleri",serialize($yetkili_kullanici_rolleri_y));
}

// eski yazilar icin default ayarlari options'a ekleme
if(isset($eskiler_kullanici_rolleri)){
update_option("eskiler_kullanici_rolleri",serialize($eskiler_kullanici_rolleri_y));
}else{
add_option("eskiler_kullanici_rolleri",serialize($eskiler_kullanici_rolleri_y));
}

// ziyaretciyi eskiler icin ekleme alani
if(isset($_POST["sitekimlergorsun_ziyaretci"])){
$sitekimlergorsun_kullanici_rolleri_y[] = "ziyaretci";
}

// eski yazilar icin default ayarlari options'a ekleme
if(isset($sitekimlergorsun_kullanici_rolleri)){
update_option("sitekimlergorsun_kullanici_rolleri",serialize($sitekimlergorsun_kullanici_rolleri_y));
}else{
add_option("sitekimlergorsun_kullanici_rolleri",serialize($sitekimlergorsun_kullanici_rolleri_y));
}


// yeni grup ekleme alani
if(!empty($_POST["yeni_grup_ekle"])){

// grup ismini degisik karakterlerden temizleme
$yeni_isim=preg_replace('/[^a-z0-9]/i',' ', $_POST["yeni_grup_ekle"]);
$en_yeni_isim=str_replace(" ","_",$yeni_isim);

/**/
	 $result = add_role(
    $en_yeni_isim,
    $_POST["yeni_grup_ekle"],
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => true,
        'delete_posts' => false, // Use false to explicitly deny
    )
);
if ( null !== $result ) {
    echo __('<hr>New group (role) created!');
}
else {
    echo __('This group (role) already exists.');
}

}

// gizli icerikler icin uyari yazisi.
if(!empty($_POST["gizli_icerik_uyari"])){

// optionsa ekleme
if(isset($gizli_icerik_uyari)){
update_option("gizli_icerik_uyari",$_POST["gizli_icerik_uyari"]);
}else{
add_option("gizli_icerik_uyari",$_POST["gizli_icerik_uyari"]);
}

}

// yazilar icin yonlendirme linki
if(!empty($_POST["gizli_icerik_yonlendirme_linki"])){

 //ayarlardan sayfa linkini cekeriz
 $gizli_icerik_yonlendirme_linki = get_option("gizli_icerik_yonlendirme_linki"); 

// optionsa ekleme
if(isset($gizli_icerik_yonlendirme_linki)){
update_option("gizli_icerik_yonlendirme_linki",$_POST["gizli_icerik_yonlendirme_linki"]);
}else{
add_option("gizli_icerik_yonlendirme_linki",$_POST["gizli_icerik_yonlendirme_linki"]);
}

}

// tax lar icin yonlendirme linki
if(!empty($_POST["gizli_tax_yonlendirme_linki"])){

 //ayarlardan sayfa linkini cekeriz
 $gizli_tax_yonlendirme_linki = get_option("gizli_tax_yonlendirme_linki"); 

// optionsa ekleme
if(isset($gizli_tax_yonlendirme_linki)){
update_option("gizli_tax_yonlendirme_linki",$_POST["gizli_tax_yonlendirme_linki"]);
}else{
add_option("gizli_tax_yonlendirme_linki",$_POST["gizli_tax_yonlendirme_linki"]);
}

}

	 //ayarlardan sayfa linkini cekeriz
	 $eskiler_iptalmi = get_option("eskiler_iptalmi"); 

	// default iptalmi ayari
	if(!empty($_POST["eskiler_iptalmi"])){

		// optionsa ekleme
		if(isset($eskiler_iptalmi)){
		update_option("eskiler_iptalmi",$_POST["eskiler_iptalmi"]);
		}else{
		add_option("eskiler_iptalmi",$_POST["eskiler_iptalmi"]);
		}

	}else{

		// optionsa ekleme
		if(isset($eskiler_iptalmi)){
		update_option("eskiler_iptalmi","iptal_etme");
		}else{
		add_option("eskiler_iptalmi","iptal_etme");
		}


	}

$guncellendimi = __("Update success..","k_group");
}

 //ayarlardan uyari metnini cekeriz
 $gizli_icerik_uyari = get_option("gizli_icerik_uyari"); 

 //ayarlardan sayfa linkini cekeriz
 $gizli_icerik_yonlendirme_linki = get_option("gizli_icerik_yonlendirme_linki"); 

 //ayarlardan sayfa linkini cekeriz
 $gizli_tax_yonlendirme_linki = get_option("gizli_tax_yonlendirme_linki"); 
 
?> <hr><?php echo (isset($guncellendimi) ? $guncellendimi : ""); ?><hr>
<form method="POST" action="">
<table class="form-table">
<tr valign="top">
	<th scope="row"><label for="k_group"><?php echo __("Default groups","k_group"); ?></label></th>
	<td>
<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="<?php echo $key; ?>" name="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php if($key == "administrator"){ ?>disabled<?php } ?> <?php if(is_array(unserialize(get_option("default_kullanici_rolleri"))) && in_array($key, unserialize(get_option("default_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo $value['name']; ?> --- <em><?php echo $key; ?></em><br>

<?php endforeach; ?>
<input type="checkbox" id="ziyaretci" name="ziyaretci" value="ziyaretci" <?php if(is_array(unserialize(get_option("default_kullanici_rolleri"))) && in_array("ziyaretci", unserialize(get_option("default_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo __("Visitors","k_group"); ?> --- <em>ziyaretci</em><br>
</td>
	<td><b><?php echo __("Post or page groups selected here by default when editing the selected income.","k_group"); ?></b></td>
</tr>


<tr valign="top">
	<th scope="row"><label for="k_group"><?php echo __("Which groups can use the plugin ?:","k_group"); ?></label></th>
	<td>
 

<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="yetkili_<?php echo $key; ?>" name="yetkili_<?php echo $key; ?>" value="yetkili_<?php echo $key; ?>" <?php if($key == "administrator" || $key == "subscriber"){ ?>disabled<?php } ?> <?php if(is_array(unserialize(get_option("yetkili_kullanici_rolleri"))) && in_array($key, unserialize(get_option("yetkili_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo $value['name']; ?><br>

<?php endforeach; ?>
</td>
	<td><b><?php echo __("Which group would you like to empower: text editing section groups the authority to use the selection field","k_group"); ?></b></td>
</tr>


<tr valign="top">
	<th scope="row"><label for="k_group"><?php echo __("Articles out of whack for the default groups:","k_group"); ?></label></th>
	<td>
<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="eskiler_<?php echo $key; ?>" name="eskiler_<?php echo $key; ?>" value="eskiler_<?php echo $key; ?>" <?php if($key == "administrator"){ ?>disabled<?php } ?> <?php if(is_array(unserialize(get_option("eskiler_kullanici_rolleri"))) && in_array($key, unserialize(get_option("eskiler_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo $value['name']; ?><br>
<?php endforeach; ?>
<input type="checkbox" id="eskiler_ziyaretci" name="eskiler_ziyaretci" value="ziyaretci" <?php if(is_array(unserialize(get_option("default_kullanici_rolleri"))) && in_array("ziyaretci", unserialize(get_option("eskiler_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo __("Visitors","k_group"); ?><br>

<hr>
<input type="checkbox" id="eskiler_iptalmi" name="eskiler_iptalmi" value="iptal_et" <?php if(get_option("eskiler_iptalmi") && get_option("eskiler_iptalmi") == "iptal_et"){ ?>checked<?php } ?>> <?php echo __("Disable default for post v.s","k_group"); ?><br>

</td>
	<td><b><?php echo __("Older posts and pages, If you have to choose the groups you want to show for settings will apply here.","k_group"); ?></b></td>
</tr>

<tr valign="top">
	<th scope="row"><label for="k_group"><?php echo __("Delete groups:","k_group"); ?></label></th>
	<td>
 

<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="silgitsin_<?php echo $key; ?>" name="silgitsin_<?php echo $key; ?>" value="silgitsin_<?php echo $key; ?>" <?php if($key == "administrator" || $key == "editor" || $key == "author" || $key == "contributor" || $key == "subscriber"){ ?>disabled<?php } ?>> <?php echo $value['name']; ?><br>

<?php endforeach; ?>
</td>
	<td><b><?php echo __("You can choose the group you want to delete. There is no turning back, I'm telling you :)","k_group"); ?></b></td>
</tr>


<tr valign="top">
	<th scope="row"><label for="pid"><?php echo __("Add a new group","k_group"); ?></label></th>
	<td><input name="yeni_grup_ekle" id="yeni_grup_ekle" type="text" value="" style="width:90%;" /></td>
	<td><?php echo __("Adding new groups can give authorization desired.","k_group"); ?></td>

</tr>
<tr valign="top">
	<th scope="row"><label for="pid"><?php echo __("Explanation for the secret articles","k_group"); ?></label></th>
	<td><textarea id="gizli_icerik_uyari" name="gizli_icerik_uyari" style="width:90%;height:100px;"><?php echo stripslashes($gizli_icerik_uyari); ?></textarea></td>
	<td><?php echo __("You can change the description of the parts of secret writing.","k_group"); ?></td>
</tr>

<tr valign="top">
	<th scope="row"><label for="pid"><?php echo __("Entries will be redirected to the page link","k_group"); ?></label></th>
	<td><input name="gizli_icerik_yonlendirme_linki" id="gizli_icerik_yonlendirme_linki" type="text" value="<?php echo $gizli_icerik_yonlendirme_linki; ?>" style="width:90%;" /></td>
	<td><?php echo __("Hidden articles will be redirected to the page your link text.","k_group"); ?></td>

</tr>

<tr valign="top">
	<th scope="row"><label for="pid"><?php echo __("Categories and tags will be redirected to the page link","k_group"); ?></label></th>
	<td><input name="gizli_tax_yonlendirme_linki" id="gizli_tax_yonlendirme_linki" type="text" value="<?php echo $gizli_tax_yonlendirme_linki; ?>" style="width:90%;" /></td>
	<td><?php echo __("Hidden categories, and tags will be redirected to the page you link to article","k_group"); ?></td>

</tr>
<tr valign="top">
	<th scope="row"><label for="k_group"><?php echo __("Who can see this site?","k_group"); ?></label></th>
	<td>
<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="sitekimlergorsun_<?php echo $key; ?>" name="sitekimlergorsun_<?php echo $key; ?>" value="sitekimlergorsun_<?php echo $key; ?>" <?php if($key == "administrator"){ ?>disabled<?php } ?> <?php if(is_array(unserialize(get_option("sitekimlergorsun_kullanici_rolleri"))) && in_array($key, unserialize(get_option("sitekimlergorsun_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo $value['name']; ?><br>

<?php endforeach; ?>
<input type="checkbox" id="sitekimlergorsun_ziyaretci" name="sitekimlergorsun_ziyaretci" value="sitekimlergorsun_ziyaretci" <?php if(is_array(unserialize(get_option("sitekimlergorsun_kullanici_rolleri"))) && in_array("ziyaretci", unserialize(get_option("sitekimlergorsun_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo __("Visitors","k_group"); ?><br>
</td>
	<td><b><?php echo __("Group without the approval of the designated page, are directed (above)","k_group"); ?></b></td>
</tr>


</table>

<p class="submit"><input type="submit" class="button-primary" value="<?php echo __("Update","k_group"); ?>" /></p>
</form>
<?php
}

/*
*
*
*
*
*/

	/**
	 * konu duzenleme sayfasina wlops options alanini ekleriz.
	 */
	function k_group_add_meta_box( $post_type ) {
		global $post;

            $post_types = array('post', 'page');     //limit meta box to certain post types
            if ( in_array( $post_type, $post_types )) {
		add_meta_box(
			'k_hidden_group'
			,__( 'Kuaza show group role options', 'k_group' )
			,'render_k_group_konu_ayarlarini_goster'
			,$post_type
			,'advanced'
			,'high',
			array("k_group_izinli_gruplar","k_group_iptalet")
		);
            }
	}

	/**
	 * Save the meta when the post is saved.
	 * 
	 * @param int $post_id The ID of the post being saved.
	 */
	function k_group_save_meta_options( $post_id ) {
	global $wp_roles;
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['k_group_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['k_group_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'k_group_inner_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// sayfaya ozel grup ayarlarini guncelleriz
		$yazi_kullanici_rolleri_y = array();

		foreach ( $wp_roles->roles as $key=>$value ):

			/* yetkili */
			if(isset($_POST["konu_kullanici_rolleri_".$key]) && $_POST["konu_kullanici_rolleri_".$key] == "konu_kullanici_rolleri_".$key){

			$yazi_kullanici_rolleri_y[] = $key;

			}

		endforeach;

		// ziyaretciyi default icin ekleme alani
		if(isset($_POST["ziyaretci"])){
		$yazi_kullanici_rolleri_y[] = "ziyaretci";
		}


		update_post_meta( $post_id, '_k_group_izinli_gruplar', serialize($yazi_kullanici_rolleri_y) );
		
		$iptaletsinmi = (!empty($_POST['k_group_iptalet']) && $_POST['k_group_iptalet'] == "iptal_et" ? "iptal_et" : "iptal_etme" );
		update_post_meta( $post_id, '_k_group_iptalet', $iptaletsinmi );	
							
	}


	/**
	 * konu duzenleme yada ekleme sayfasinda wlops options bolumunu gosterelim, ayiklayalim..
	 *
	 * @param WP_Post $post The post object.
	 */
	function render_k_group_konu_ayarlarini_goster( $post, $metabox ) {
		global $wp_roles;
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'k_group_inner_custom_box', 'k_group_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		

		foreach($metabox['args'] as $k_group_meta){

			$alan_icerigi = get_post_meta( $post->ID, '_'.$k_group_meta, true );

			if($k_group_meta == "k_group_izinli_gruplar"){
			$k_group_aciklama_meta = __("Who can see this page?","k_group");

				echo '<div class="yuzdeyuzyap">';
				echo '<label for="'.$k_group_meta.'" class="yuzdeyuzyap">'.$k_group_aciklama_meta.'</label><br>
				';
				?>
			<?php
			$alan_icerigi_coz = unserialize($alan_icerigi);

			if(isset($alan_icerigi_coz) && is_array($alan_icerigi_coz)){

			$roller = $alan_icerigi_coz;

			}else{
			$roller = unserialize(get_option("default_kullanici_rolleri"));
			}


			 foreach ( $wp_roles->roles as $key=>$value ): ?>
			<input type="checkbox" id="konu_kullanici_rolleri_<?php echo $key; ?>" name="konu_kullanici_rolleri_<?php echo $key; ?>" value="konu_kullanici_rolleri_<?php echo $key; ?>" <?php if($key == "administrator"){ ?>disabled<?php } ?> <?php if(in_array($key, $roller)){ ?>checked<?php } ?>> <?php echo $value['name']; ?> --- Key: <em><?php echo $key; ?></em><br>

			<?php endforeach; ?>
			<input type="checkbox" id="ziyaretci" name="ziyaretci" value="ziyaretci" <?php if(in_array("ziyaretci", $roller)){ ?>checked<?php } ?>> <?php echo __("Visitors","k_group"); ?> --- Key: <em>ziyaretci</em><br>
						
				<?php
				echo '</div><br>';


			}elseif($k_group_meta == "k_group_iptalet"){
			
					$eskiler_iptalmi = get_option("eskiler_iptalmi"); 
					$alan_icerigi = (!empty($alan_icerigi) ? $alan_icerigi : (!empty($eskiler_iptalmi) ? $eskiler_iptalmi : "iptal_et"));
			
			$k_group_aciklama_meta = __("Disable k_hidden_group plugin for this post!","k_group"); 
			echo '<div class="yuzdeyuzyap">';	
				?>
			<input type="checkbox" id="k_group_iptalet" name="k_group_iptalet" value="iptal_et" <?php if($alan_icerigi == "iptal_et"){ ?>checked<?php } ?>> <?php echo __("Disable for this post","k_group"); ?><br>
							
				<?php
				echo '
				
				
				<label for="'.$k_group_meta.'" class="yuzdeyuzyap">'.$k_group_aciklama_meta.'</label></div><br>';
			
			}else{
			
			}

		}		
		

	}

/*
*
*
*
*
*/

// http://wordpress.org/plugins/taxonomy-metadata/
class Taxonomy_Metadata {
	function __construct() {
		add_action( 'init', array($this, 'wpdbfix') );
		add_action( 'switch_blog', array($this, 'wpdbfix') );
		add_action('wpmu_new_blog', array($this, 'new_blog'), 10, 6);
	}

	/*
	 * Quick touchup to wpdb
	 */
	function wpdbfix() {
		global $wpdb;
		$wpdb->taxonomymeta = "{$wpdb->prefix}taxonomymeta";
	}
	
	/*
	 * TABLE MANAGEMENT
	 */

	function activate( $network_wide = false ) {
		global $wpdb,$wp_roles;
	
	/*
	* eski yazilar icin default ayarlar eklenir. butun gruplara gorme yetisi verilir, adminden degistirilebilir sonrasinda :)
	*/
	//eski yazilar icin gorebilecek default gruplar
	$eskiler_kullanici_rolleri = get_option("eskiler_kullanici_rolleri"); 
	$default_kullanici_rolleri = get_option("default_kullanici_rolleri"); 
	$sitekimlergorsun_kullanici_rolleri = get_option("sitekimlergorsun_kullanici_rolleri");
	
	$eskiler_kullanici_rolleri_y = array();
	foreach ( $wp_roles->roles as $key=>$value ):
	$eskiler_kullanici_rolleri_y[] = $key;
	
	if(empty($sitekimlergorsun_kullanici_rolleri)){
	$sitekimlergorsun_kullanici_rolleri_y[] = $key;
	}
	endforeach;
	
	$eskiler_kullanici_rolleri_y[] = "ziyaretci";
	
	if(empty($sitekimlergorsun_kullanici_rolleri)){
	$sitekimlergorsun_kullanici_rolleri_y[] = "ziyaretci";
	}
	
	// eski yasilar icin  ve default secilecek gruplar
	add_option("eskiler_kullanici_rolleri",serialize($eskiler_kullanici_rolleri_y));
	add_option("default_kullanici_rolleri",serialize($eskiler_kullanici_rolleri_y));
	
	// siteyi kimler gorebilir N;
	add_option("sitekimlergorsun_kullanici_rolleri",serialize($sitekimlergorsun_kullanici_rolleri_y));
	
	// eklenti icin yetkili gruplar
	add_option("yetkili_kullanici_rolleri",serialize(array("administrator","editor")));
	
		// if activated on a particular blog, just set it up there.
		if ( !$network_wide ) {
			$this->setup_blog();
			return;
		}
	
		$blogs = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs} WHERE site_id = '{$wpdb->siteid}'" );
		foreach ( $blogs as $blog_id ) {
			$this->setup_blog( $blog_id );
		}
		// I feel dirty... this line smells like perl.
		do {} while ( restore_current_blog() );
	}
	
	function setup_blog( $id = false ) {
		global $wpdb;
		
		if ( $id !== false)
			switch_to_blog( $id );
	
		$charset_collate = '';	
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
	
		$tables = $wpdb->get_results("show tables like '{$wpdb->prefix}taxonomymeta'");
		if (!count($tables))
			$wpdb->query("CREATE TABLE {$wpdb->prefix}taxonomymeta (
				meta_id bigint(20) unsigned NOT NULL auto_increment,
				taxonomy_id bigint(20) unsigned NOT NULL default '0',
				meta_key varchar(255) default NULL,
				meta_value longtext,
				PRIMARY KEY	(meta_id),
				KEY taxonomy_id (taxonomy_id),
				KEY meta_key (meta_key)
			) $charset_collate;");
	}

	function new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
		if ( is_plugin_active_for_network(plugin_basename(__FILE__)) )
			$this->setup_blog($blog_id);
	}
}
$taxonomy_metadata = new Taxonomy_Metadata;
register_activation_hook( __FILE__, array($taxonomy_metadata, 'activate') );

// THE REST OF THIS CODE IS FROM http://core.trac.wordpress.org/ticket/10142
// BY sirzooro

//
// Taxonomy meta functions
//

/**
 * Add meta data field to a term.
 *
 * @param int $term_id Post ID.
 * @param string $key Metadata name.
 * @param mixed $value Metadata value.
 * @param bool $unique Optional, default is false. Whether the same key should not be added.
 * @return bool False for failure. True for success.
 */
function add_term_meta($term_id, $meta_key, $meta_value, $unique = false) {
	return add_metadata('taxonomy', $term_id, $meta_key, $meta_value, $unique);
}

/**
 * Remove metadata matching criteria from a term.
 *
 * You can match based on the key, or key and value. Removing based on key and
 * value, will keep from removing duplicate metadata with the same key. It also
 * allows removing all metadata matching key, if needed.
 *
 * @param int $term_id term ID
 * @param string $meta_key Metadata name.
 * @param mixed $meta_value Optional. Metadata value.
 * @return bool False for failure. True for success.
 */
function delete_term_meta($term_id, $meta_key, $meta_value = '') {
	return delete_metadata('taxonomy', $term_id, $meta_key, $meta_value);
}

/**
 * Retrieve term meta field for a term.
 *
 * @param int $term_id Term ID.
 * @param string $key The meta key to retrieve.
 * @param bool $single Whether to return a single value.
 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single
 *  is true.
 */
function get_term_meta($term_id, $key, $single = false) {
	return get_metadata('taxonomy', $term_id, $key, $single);
}

/**
 * Update term meta field based on term ID.
 *
 * Use the $prev_value parameter to differentiate between meta fields with the
 * same key and term ID.
 *
 * If the meta field for the term does not exist, it will be added.
 *
 * @param int $term_id Term ID.
 * @param string $key Metadata key.
 * @param mixed $value Metadata value.
 * @param mixed $prev_value Optional. Previous value to check before removing.
 * @return bool False on failure, true if success.
 */
function update_term_meta($term_id, $meta_key, $meta_value, $prev_value = '') {
	return update_metadata('taxonomy', $term_id, $meta_key, $meta_value, $prev_value);
}

/*
*
*
*
*
*/
// http://www.smashingmagazine.com/2012/01/04/create-custom-taxonomies-wordpress/

/**
 * Add additional fields to the taxonomy add view
 * e.g. /wp-admin/edit-tags.php?taxonomy=category
 */
function taxonomy_metadata_add( $tag ) {
global $wp_roles;
  // Only allow users with capability to publish content
  if ( current_user_can( 'publish_posts' ) ): 
  				$eskiler_iptalmi = get_option("eskiler_iptalmi"); 
			?>
  <div class="form-field_kuaza">
    <label for="meta_kullanici_rolleri"><?php _e("Who can see this page?","k_group"); ?></label>
<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="meta_kullanici_rolleri_<?php echo $key; ?>" name="meta_kullanici_rolleri_<?php echo $key; ?>" value="meta_kullanici_rolleri_<?php echo $key; ?>" <?php if($key == "administrator"){ ?>disabled<?php } ?> <?php if(is_array(unserialize(get_option("default_kullanici_rolleri"))) && in_array($key, unserialize(get_option("default_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo $value['name']; ?><br>

<?php endforeach; ?>
<input type="checkbox" id="ziyaretci" name="ziyaretci" value="ziyaretci" <?php if(is_array(unserialize(get_option("default_kullanici_rolleri"))) && in_array("ziyaretci", unserialize(get_option("default_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo __("Visitors","k_group"); ?><br>
<hr>
<input type="checkbox" id="meta_kullanici_rolleri_iptalmi" name="meta_kullanici_rolleri_iptalmi" value="iptal_et" <?php if($eskiler_iptalmi == "iptal_et"){ ?>checked<?php } ?>> <?php echo __("Disable for hidden option","k_group"); ?><br>
<br>
  </div>

  <?php endif;
}

/**
 * Add additional fields to the taxonomy edit view
 * e.g. /wp-admin/edit-tags.php?action=edit&taxonomy=category&tag_ID=27&post_type=post
 */
function taxonomy_metadata_edit( $tag ) {
global $wp_roles;
  // Only allow users with capability to publish content
  if ( current_user_can( 'publish_posts' ) ): ?>
  <tr class="form-field-kuaza">
    <th scope="row" valign="top">
      <label for="meta_kullanici_rolleri"><?php _e("Who can see this page?","k_group"); ?></label>
    </th>
    <td>

<?php 
//$tax_user_rolleri = array();
$tax_user_rolleri = get_term_meta($tag->term_id, 'meta_kullanici_rolleri', true);
$tax_user_rolleri = (!empty($tax_user_rolleri) ? unserialize($tax_user_rolleri) : "");
 
$tax_iptalmi = get_term_meta($tag->term_id, 'meta_kullanici_rolleri_iptalmi', true);

if(!empty($tax_user_rolleri) || is_array($tax_user_rolleri)){
foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="meta_kullanici_rolleri_<?php echo $key; ?>" name="meta_kullanici_rolleri_<?php echo $key; ?>" value="meta_kullanici_rolleri_<?php echo $key; ?>" <?php if($key == "administrator"){ ?>disabled<?php } ?> <?php if(is_array(unserialize(get_term_meta($tag->term_id, 'meta_kullanici_rolleri', true))) && in_array($key, unserialize(get_term_meta($tag->term_id, 'meta_kullanici_rolleri', true)))){ ?>checked<?php } ?>> <?php echo $value['name']; ?><br>

<?php endforeach; ?>
<input type="checkbox" id="ziyaretci" name="ziyaretci" value="ziyaretci" <?php if(in_array("ziyaretci", $tax_user_rolleri)){ ?>checked<?php } ?>> <?php echo __("Visitors","k_group"); ?><br>
<?php 
}else{
?>
<?php foreach ( $wp_roles->roles as $key=>$value ): ?>
<input type="checkbox" id="meta_kullanici_rolleri_<?php echo $key; ?>" name="meta_kullanici_rolleri_<?php echo $key; ?>" value="meta_kullanici_rolleri_<?php echo $key; ?>" <?php if($key == "administrator"){ ?>disabled<?php } ?> <?php if(is_array(unserialize(get_option("default_kullanici_rolleri"))) && in_array($key, unserialize(get_option("default_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo $value['name']; ?><br>

<?php endforeach; ?>
<input type="checkbox" id="ziyaretci" name="ziyaretci" value="ziyaretci" <?php if(is_array(unserialize(get_option("default_kullanici_rolleri"))) && in_array("ziyaretci", unserialize(get_option("default_kullanici_rolleri")))){ ?>checked<?php } ?>> <?php echo __("Visitors","k_group"); ?><br>

<?php
}
 ?>
 
 <hr>
<input type="checkbox" id="meta_kullanici_rolleri_iptalmi" name="meta_kullanici_rolleri_iptalmi" value="iptal_et" <?php if($tax_iptalmi == "iptal_et"){ ?>checked<?php } ?>> <?php echo __("Disable for hidden option","k_group"); ?><br>
<br>

    </td>
  </tr>
  <?php endif;
}

/**
 * Save taxonomy metadata
 *
 * Currently the Taxonomy Metadata plugin is needed to add a few features to the WordPress core
 * that allow us to store this information into a new database table
 *
 *  http://wordpress.org/extend/plugins/taxonomy-metadata/
 */
function save_taxonomy_metadata( $term_id ) {
global $wp_roles;

  if ( isset($_POST) ){
  $default_kullanici_rolleri_y = array();
 foreach ( $wp_roles->roles as $key=>$value ):

/*default */
if(isset($_POST["meta_kullanici_rolleri_".$key]) && $_POST["meta_kullanici_rolleri_".$key] == "meta_kullanici_rolleri_".$key){

$default_kullanici_rolleri_y[] = $key;

}


endforeach;
// ziyaretciyi default icin ekleme alani
if(isset($_POST["ziyaretci"])){
$default_kullanici_rolleri_y[] = "ziyaretci";
}

// kategori yada etiketler icin iptal etme bolumunu guncelleriz.
if(isset($_POST["meta_kullanici_rolleri_iptalmi"])){
update_term_meta( $term_id, 'meta_kullanici_rolleri_iptalmi', "iptal_et" );
}else{
update_term_meta( $term_id, 'meta_kullanici_rolleri_iptalmi', "iptal_etme" );
}
    update_term_meta( $term_id, 'meta_kullanici_rolleri', serialize($default_kullanici_rolleri_y) );
	
}

}

/**
 * Add additional taxonomy fields to all public taxonomies
 */
function taxonomy_metadata_init() {
  // Require the Taxonomy Metadata plugin
  if( !function_exists('update_term_meta') || !function_exists('get_term_meta') ) return false;

  // Get a list of all public custom taxonomies
  $taxonomies = get_taxonomies( array(
    'public'   => true,
    '_builtin' => true
  ), 'names', 'and');

  // Attach additional fields onto all custom, public taxonomies
  if ( $taxonomies ) {
    foreach ( $taxonomies  as $taxonomy ) {
      // Add fields to "add" and "edit" term pages
      add_action("{$taxonomy}_add_form_fields", 'taxonomy_metadata_add', 10, 1);
      add_action("{$taxonomy}_edit_form_fields", 'taxonomy_metadata_edit', 10, 1);
      // Process and save the data
      add_action("created_{$taxonomy}", 'save_taxonomy_metadata', 10, 1);
      add_action("edited_{$taxonomy}", 'save_taxonomy_metadata', 10, 1);
    }
  }
}
add_action('admin_init', 'taxonomy_metadata_init');
/*
*
*
*
*
*/
