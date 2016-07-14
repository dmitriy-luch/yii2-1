<?php

use backend\models\StaticType;
// TODO: Cutter total refactoring required. Replace with appropriate class once done.
use WondersLabCorporation\cutter\Cutter;
use WondersLabCorporation\UnlimitedNumber\UnlimitedNumberInputWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StaticContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="static-content-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php switch ($model->type->editor_type) :
        case StaticType::EDITOR_TYPE_WYSIWYG : ?>
            <?php // TODO: Adjust TinyMCE according to generic needs ?>
            <?= $form->field($model, 'content')->widget(\dosamigos\tinymce\TinyMce::className(), []) ?>
        <?php break; ?>
        <?php case StaticType::EDITOR_TYPE_TEXTAREA : ?>
            <?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>
        <?php break; ?>
        <?php case StaticType::EDITOR_TYPE_TEXTINPUT : ?>
            <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
        <?php break;
            endswitch; ?>

    <?php if ($model->type->type == StaticType::TYPE_PAGE) : ?>
        <?= $form->field($model, 'slug')
            ->widget(
                // Adjusting Unlimited number widget to truncate field value when checkbox is checked
                UnlimitedNumberInputWidget::className(),
                [
                    'unlimitedValue' => null,
                    'emptyValue' => '',
                    'checkboxOptions' => ['label' => Yii::t('backend', 'Generate automatically')],
                    'options' => ['type' => 'text'],
                ]
        ) ?>
    <?php endif;?>

    <?php if ($model->type->is_image_required) : ?>
        <?= $form->field($model, 'image')->widget(Cutter::className()); ?>
    <?php endif;?>
    
    <?= $form->field($model ,'status')->dropDownList(\backend\models\StaticContent::getStatusTexts()); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>