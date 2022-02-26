<?php if($responsive == true){ ?>

<?php 

    $ext = ($webp == true) ? 'webp' : $media->ext;
    $srcsetWebp = '';
    $srcset = '';
    foreach($sizes as $size){ 
        $srcsetWebp .=  site_url($path . 'responsive-images' . DIRECTORY_SEPARATOR . $media->localname . '_' . $size . 'w.' . $ext) . ' ' . $size . 'w, ';
        $srcset .= site_url($path . 'responsive-images' . DIRECTORY_SEPARATOR . $media->localname . '_' . $size . 'w.' . $media->ext) . ' ' . $size . 'w, ';
    } 
?>
    <picture>
        <source sizes="(max-width: 480px) 360px,
                    (max-width: 480px) and (min-device-pixel-ratio: 1.25) 720px,
                    100vw" 
                type="image/webp" 
                data-srcset="<?= $srcset; ?>">

        <img    data-src="<?= site_url($path . 'responsive-images' . DIRECTORY_SEPARATOR . $media->localname . '.' . $media->ext); ?>" class="lazy adw_check_if_is_visible img-fluid" alt="<?= $media->getName(); ?>" sizes="(max-width: 480px) 360px,
                (max-width: 480px) and (min-device-pixel-ratio: 1.25) 720px,
                100vw" 
                srcset="<?= $srcset; ?>">
        <noscript>
            <img data-src="<?= site_url($path . 'responsive-images' . DIRECTORY_SEPARATOR . $media->localname . '.' . $media->ext); ?>" 
            srcset="<?= $srcset; ?>" 
                sizes="(max-width: 480px) 375px,
                    (max-width: 480px) and (min-device-pixel-ratio: 1.25) 750px,
                    100vw" 
                class="lazy adw_check_if_is_visible img-fluid" 
                alt="<?= $media->getName(); ?>">
        </noscript>
    </picture>

<?php }else{ ?>
    <picture>
        <img class="lazy img-responsive responsive smooth_arrival" alt="<?= $media->getName(); ?>" data-src="<?= site_url('medias/'.$dir.'/' . $media->filename); ?>">
    </picture>
<?php } ?>