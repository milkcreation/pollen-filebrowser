<?php
/**
 * @var Pollen\Filebrowser\FilebrowserViewLoaderInterface $this
 * @var tiFy\Template\Templates\FileManager\Contracts\FileInfo $file
 */
?>
<div class="Filebrowser-finfo">
    <div class="Filebrowser-finfoPreview">
        <?php echo $this->preview($file); ?>
    </div>
    <?php if ($file->isFile()) : ?>
    <ul class="Filebrowser-finfoHandlers">
        <li class="Filebrowser-finfoHandler Filebrowser-finfoHandler--download">
            <a href="<?php echo $file->getDownloadUrl(); ?>"
               class="Filebrowser-finfoHandlerLink"
               data-control="filebrowser.handler.download"
            >
                <?php echo $this->getIcon('download'); ?><?php _e('Télécharger', 'tify'); ?>
            </a>
        </li>
    </ul>
    <?php endif; ?>
    <ul class="Filebrowser-finfoAttrs">
        <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--name">
            <label class="Filebrowser-finfoAttrLabel"><?php _e('Nom :', 'tify'); ?></label>
            <span class="Filebrowser-finfoAttrValue"><?php echo $file->getBasename(); ?></span>
        </li>
        <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--type">
            <label class="Filebrowser-finfoAttrLabel"><?php _e('Type :', 'tify'); ?></label>
            <span class="Filebrowser-finfoAttrValue"><?php echo $file->getHumanType(); ?></span>
        </li>
        <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--ext">
            <label class="Filebrowser-finfoAttrLabel"><?php _e('Type de médias :', 'tify'); ?></label>
            <span class="Filebrowser-finfoAttrValue"><?php echo $file->getMimetype(); ?></span>
        </li>
        <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--size">
            <label class="Filebrowser-finfoAttrLabel"><?php _e('Taille :', 'tify'); ?></label>
            <span class="Filebrowser-finfoAttrValue"><?php echo $file->getHumanSize(); ?></span>
        </li>
        <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--date">
            <label class="Filebrowser-finfoAttrLabel"><?php _e('Date :', 'tify'); ?></label>
            <span class="Filebrowser-finfoAttrValue"><?php echo $file->getHumanDate('d/m/Y'); ?></span>
        </li>
        <?php /* if ($file->isLocal()) : ?>
            <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--ctime">
                <label class="Filebrowser-finfoAttrLabel"><?php _e('Création :', 'tify'); ?></label>
                <span class="Filebrowser-finfoAttrValue"><?php echo $file->getHumanDate('d/m/Y'); ?></span>
            </li>
            <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--mtime">
                <label class="Filebrowser-finfoAttrLabel"><?php _e('Modification :', 'tify'); ?></label>
                <span class="Filebrowser-finfoAttrValue"><?php echo $file->getMTime(); ?></span>
            </li>
            <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--owner">
                <label class="Filebrowser-finfoAttrLabel"><?php _e('Propriétaire :', 'tify'); ?></label>
                <span class="Filebrowser-finfoAttrValue"><?php echo $file->getOwner(); ?></span>
            </li>
            <li class="Filebrowser-finfoAttr Filebrowser-finfoAttr--group">
                <label class="Filebrowser-finfoAttrLabel"><?php _e('Groupe :', 'tify'); ?></label>
                <span class="Filebrowser-finfoAttrValue"><?php echo $file->getGroup(); ?></span>
            </li>
        <?php endif; */ ?>
    </ul>
    <?php if (!$file->isRoot()) : ?>
        <ul class="Filebrowser-finfoActions">
            <li class="Filebrowser-finfoAction Filebrowser-finfoAction--rename">
                <?php $this->insert('action-rename', compact('file')); ?>
                <div class="Filebrowser-finfoActionButton">
                    <a href="#"
                       class="Filebrowser-button Filebrowser-button--toggle"
                       data-control="filebrowser.action.toggle"
                       data-action="rename"
                    ><?php _e('Renommer', 'tify'); ?></a>
                </div>
            </li>

            <li class="Filebrowser-finfoAction Filebrowser-finfoAction--delete">
                <?php $this->insert('action-delete', compact('file')); ?>
                <div class="Filebrowser-finfoActionButton">
                    <a href="#"
                       class="Filebrowser-button Filebrowser-button--toggle"
                       data-control="filebrowser.action.toggle"
                       data-action="delete"
                    ><?php _e('Supprimer', 'tify'); ?></a>
                </div>
            </li>
        </ul>
    <?php endif; ?>
</div>