 <?php $form->prepare();  ?>
<?php echo $this->form()->openTag($form); ?>

    <div class="form-element">
        <?php $fileElement = $form->get('offdays-file'); ?>
        <?php echo $this->formLabel($fileElement); ?>
        <?php echo $this->formFile($fileElement); ?>
        <?php echo $this->formElementErrors($fileElement); ?>
    </div>

    <button>загрузить</button>

<?php echo $this->form()->closeTag(); ?>
