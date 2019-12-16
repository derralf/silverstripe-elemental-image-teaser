<?php

namespace Derralf\Elements\ImageTeaser\Model;

use Derralf\Elements\ImageTeaser\Element\ElementImageTeaserHolder;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;


class ElementImageTeaser extends DataObject
{


    private static $table_name = 'ElementImageTeaser';

    private static $singular_name = 'Teaser mit Bild';
    private static $plural_name = 'Teaser mit Bild';
    private static $description = '';


    private static $extensions = [
        Versioned::class
    ];

    private static $db = [
        'Title'     => 'Varchar(255)',
        'TitleTag'  => 'Varchar(255)',
        'ShowTitle' => 'Boolean',
        'Subtitle' => 'Text',
        'Content'   => 'HTMLText',
        'Style' => 'Varchar(255)',
        'Sort' => 'Int'
    ];

    private static $has_one = [
        'TeaserHolder'  => ElementImageTeaserHolder::class,
        'Image' => Image::class,
        'ReadMoreLink' => Link::Class

    ];

    private static $has_many = [
        //'MyOtherDataObjects' => MyOtherDataObject::class
    ];

    private static $many_many = [];

    private static $belongs_many_many = [];

    private static $owns = [
        'Image',
    ];

    private static $defaults = [
        'ShowTitle' => true
    ];

    private static $use_subtitle = false;

    private static $default_sort = 'Sort ASC';

    private static $field_labels = [
        'Title'                   => 'Titel',
        'Content.LimitCharacters' => 'Inhalt',
        'Content'                 => 'Inhalt',
        'Image'                   => 'Bild',
        'Image.CMSThumbnail'      => 'Bild',
        'ReadMoreLink'            => 'Link',
        'ReadMoreLink.LinkURL'    => 'Link',
        'Sort'                    => 'Sortierung'
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail',
        'Title',
        'Content.LimitCharacters',
        'ReadMoreLink.LinkURL'
    ];

    private static $searchable_fields = [
        'Title'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            // Remove relationship fields
            $fields->removeByName('Sort');

            // Subtitle
            if (!$this->useSubtitle()) {
                $fields->removeByName('Subtitle');
            }

            //// Add a combined field for "Title" and "Displayed" checkbox in a Bootstrap input group
            //$fields->removeByName('ShowTitle');
            //$fields->replaceField(
            //    'Title',
            //    TextCheckboxGroupField::create(
            //        TextField::create('Title', _t(__CLASS__ . '.TitleLabel', 'Title (displayed if checked)')),
            //        CheckboxField::create('ShowTitle', _t(__CLASS__ . '.ShowTitleLabel', 'Displayed'))
            //    )
            //        ->setName('TitleAndDisplayed')
            //);

            // Add a combined field for "Title" and "Displayed" checkbox in a Bootstrap input group
            $fields->removeByName('ShowTitle');
            $fields->replaceField(
                'Title',
                TextCheckboxGroupField::create()
                    ->setName('Title')
            );




            // Title Tag
            $title_tags = $this->owner->getAvailableTitleTagVariants();
            if (is_array($title_tags) && !empty($title_tags)) {
                $TitleTag = new DropdownField('TitleTag', $this->owner->fieldLabel('TitleTag'), $title_tags);
                $TitleTag->setDescription(sprintf(_t(__CLASS__.'.TitleTagDescription','default: %s'), $this->owner->getTitleTagDefault()));
                $TitleTag->setEmptyString('default');
                $fields->insertAfter('TitleAndDisplayed', $TitleTag);
            } else {
                $fields->removeByName('TitleTag');
            }



            // Content
            $fields->dataFieldByName('Content')->setRows(8);

            // ReadMoreLink
            $ReadMoreLink = LinkField::create('ReadMoreLinkID', 'Link');
            $fields->replaceField('ReadMoreLinkID', $ReadMoreLink);

            // Styles (Color)
            $styles = $this->config()->get('styles');
            if ($styles && count($styles) > 0) {
                $styleDropdown = DropdownField::create('Style', _t(__CLASS__.'.STYLE', 'Style variation'), $styles);
                $fields->insertBefore('Content',$styleDropdown);
                $styleDropdown->setEmptyString(_t(__CLASS__.'.CUSTOM_STYLES', 'Select a style..'));
            } else {
                $fields->removeByName('Style');
            }

            // Image Upload konfigurieren
            // --------------------------------------------------------------------------------
            $Image = new UploadField('Image', 'Bild');
            $Image->setFolderName('element-teaser-image');
            $Image->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif'));
            $Image->getValidator()->setAllowedMaxFileSize((2 * 1024 * 1024));  // 2MB
            $Image->setDescription('Optional: Bild für Anzeige hinterlegen<br>Erlaubte Dateiformate: jpg, png, gif<br>Erlaubte Dateigröße: max. 2MB<br>Bildgröße/Format: für das Vorschaubild wird automatisch ein Ausschnitt erstellt/errechnet (Format/seitenverhältnis durch Template festgelegt)<br>Bei Bedarf kann der Focus für das Vorschau-Bild gesetzt werden: Bild > Bearbeiten > Focus Point setzen > speichern<br>Achtung! Bild speichern und Datensatz speichern sind verschiedene Buttons/Funktionen');
            $fields->replaceField('Image', $Image);


        });

        $fields = parent::getCMSFields();
        return $fields;
    }

    public function ShowImage() {
        if ($this->TeaserHolder()->exists() && $this->TeaserHolder()->HideTeaserImages) {
            return false;
        }
        return true;
    }


    /**
     * @return bool
     */
    public function useSubtitle()
    {
        if ($this->config()->get('use_subtitle')) {
            return true;
        }
    }

    /**
     * @return string
     */
    public function ReadmoreLinkClass() {
        return $this->config()->get('readmore_link_class');
    }

    /**
     * get available values for TitleTag from config
     * @return mixed
     */
    public function getAvailableTitleTagVariants()
    {
        if ($this->config()->get('title_tag_variants', Config::UNINHERITED)) {
            return $this->config()->get('title_tag_variants', Config::UNINHERITED);
        } else {
            return $this->config()->get('title_tag_variants');
        }
    }

    /**
     * get verified value from TitleTag or fallback
     * @return mixed|string
     */
    public function getTitleTagVariant()
    {
        $title_tag = $this->TitleTag;
        $title_tag_variants = $this->getAvailableTitleTagVariants();
        // only return when value is in array of available variants
        if ($title_tag && is_array($title_tag_variants) && !empty($title_tag_variants) && isset($title_tag_variants[$title_tag])) {
            return $this->TitleTag;
        }
        // return fallback
        return $this->getTitleTagDefault();
    }

    /**
     * get fallback value for TitleTag from config
     * @return mixed
     */
    public function getTitleTagDefault()
    {
        return $this->config()->get('title_tag_default');
    }




    /**
     * @return null
     */
    public function getPage()
    {
        $page = null;

        if ($this->TeaserHolder()) {
            if ($this->TeaserHolder()->hasMethod('getPage')) {
                $page = $this->TeaserHolder()->getPage();
            }
        }
        return $page;

    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @return boolean
     */
    public function canView($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canView($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canEdit($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canEdit($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * Uses archive not delete so that current stage is respected i.e if a
     * element is not published, then it can be deleted by someone who doesn't
     * have publishing permissions.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canDelete($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canArchive($member);
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @param array $context
     *
     * @return boolean
     */
    public function canCreate($member = null, $context = array())
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }




}
