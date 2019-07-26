<?php

namespace Derralf\Elements\ImageTeaser\Element;


use Derralf\Elements\ImageTeaser\Model\ElementImageTeaser;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\Tab;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\SSViewer;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ElementImageTeaserHolder extends BaseElement
{


    public function getType()
    {
        return self::$singular_name;
    }

    private static $icon = 'font-icon-block-content';

    private static $table_name = 'ElementImageTeaserHolder';

    private static $singular_name = 'Teaser-Liste';
    private static $plural_name = 'Teaser-Listen';
    private static $description = '';

    private static $db = [
        'HTML'             => 'HTMLText',
        'HideTeaserImages' => 'Boolean'
    ];


    private static $has_one = [
    ];

    private static $has_many = [
        'Teasers' => ElementImageTeaser::class
    ];

    private static $many_many = [
    ];

    // this adds the SortOrder field to the relation table.
    private static $many_many_extraFields = [
    ];

    private static $belongs_many_many = [];

    private static $owns = [
        //'Teasers'
    ];

    private static $inline_editable = false;

    private static $defaults = [
    ];

    private static $colors = [];


    private static $field_labels = [
        'Title' => 'Titel',
        'Sort' 	=>	'Sortierung'
    ];

    public function updateFieldLabels(&$labels)
    {
        parent::updateFieldLabels($labels);
        $labels['HTML'] = _t(__CLASS__ . '.ContentLabel', 'Content');
        $labels['Teasers'] = _t(__CLASS__ . '.TeasersLabel', 'Teasers');
    }

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {


            // Style: Description for default style (describes Layout thats used, when no special style is selected)
            $Style = $fields->dataFieldByName('Style');
            $StyleDefaultDescription = $this->owner->config()->get('styles_default_description', Config::UNINHERITED);
            if ($Style && $StyleDefaultDescription) {
                $Style->setDescription($StyleDefaultDescription);
            }



            $fields->addFieldToTab('Root.Teasers', $fields->dataFieldByName('HideTeaserImages'), 'Teasers');




            if ($this->ID) {
                $TeaserGridfield = $fields->dataFieldByName('Teasers');
                $TeaserGridfieldConfig = $TeaserGridfield->getConfig();
                $TeaserGridfieldConfig->removeComponentsByType('GridFieldDeleteAction');
                $TeaserGridfieldConfig->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                $TeaserGridfieldConfig->addComponent(new GridFieldAddExistingSearchButton());
                $TeaserGridfieldConfig->addComponent(new GridFieldOrderableRows('Sort'));
            }




        });
        $fields = parent::getCMSFields();

        return $fields;
    }


    public function ReadmoreLinkClass() {
        return $this->config()->get('readmore_link_class');
    }

    public function SortedImages()
    {
        return $this->Images()->Sort('SortOrder');
    }



    public function OtherImages($offset=1)
    {
        $result = $this->Images()->Sort('SortOrder')->limit(null, $offset);
        //var_dump($offset);

        if ($result && $result->count()) {
            $images = new ArrayList();
            foreach($result as $image){
                if($this->ShowImageCaptions) {
                    $image->ShowImageCaptions = true;
                }
                $images->push($image);
            }
            return $images;
        }
    }

    public function getOtherImagesTemplate()
    {
        if (!$this->ImageViewMode) {
            return false;
        }
        $template = $this->ClassName . '__OtherImages_' . $this->ImageViewMode;
        return $template;
    }

    public function getOtherImagesTemplateExists() {
        if(!$this->getOtherImagesTemplate()) {
            return false;
        }
        $template = $this->getOtherImagesTemplate();
        $template_exists = SSViewer::hasTemplate($template);
        if($template_exists){
            return $template;
        }
    }



    public function OtherImagesLayout($offset=1){
        $offset = intval($offset);
        if(!$this->ImageViewMode) return false;                            // keine weiteren Bilder anzeigen: abbrechen
        if(!$this->Images()->exists()) return false;                       // keine Bilder gefunden: abbrechen
        if(!$this->Style) $offset = 0;                                     // Layout, bei dem kein Bild "oben" verwendet wird: Offset auf 0 setzen

        if($this->OtherImages($offset) && $this->getOtherImagesTemplateExists()) {
            return $this->OtherImages($offset)->renderWith($this->getOtherImagesTemplate());
        }
    }





}
