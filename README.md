# SilverStripe Elemental Image Teaser

A block that displays teaser objects (header, image, text, link). Usually 2 to 4 objects per row - depends on the template.
(private project, no help/support provided)

## Requirements

* SilverStripe CMS ^4.3
* dnadesign/silverstripe-elemental ^4.0
* sheadawson/silverstripe-linkable ^2.0@dev
* jonom/focuspoint ^3.0

For a SilverStripe 4.2 and Elemental 3.x compatible version of this module, please see the [1.x release line](https://github.com/derralf/silverstripe-elemental-image-teaser/tree/1.0#readme).


## Suggestions
* derralf/elemental-styling

Modify `/templates/Derralf/Elements/ImageTeaser/Includes/Title.ss` to your needs when using StyledTitle from derralf/elemental-styling.


## Installation

- Install the module via Composer
  ```
  composer require derralf/elemental-image-teaser
  ```


## Configuration

A basic/default config. Add this to your **mysite/\_config/elements.yml**

Note the options for `styles` and `image_view_modes`, in which the templates contained in the extension are listed.

Set `defaults:ImageViewMode` to `null` or any of the avaiable Templates from `image_view_modes`.

Optionally you may set `defaults:Style`to any of the available `styles`.

```

---
Name: elementalimageteasers
---

Derralf\Elements\ImageTeaser\Element\ElementImageTeaserHolder:
  # disable StyledTitle
  title_tag_variants: null
  title_alignment_variants: null
  # styles
  style_default_description: 'Standard: 2 Spalten'
  styles:
    ThreeColumns: '3 Spalten'
    RoundedImage: 'Runde Bilder, 2 Spalten'
    # bootstrap 4
    ThreeColumnsBS4Cards: '3 Spalten (Bootstrap 4 Cards)'
    FourColumnsBS4Cards: '4 Spalten (Bootstrap 4 Cards)'
    RoundedImageBS4Cards: 'Runde Bilder, 2 Spalten (Bootstrap 4 Cards)'

Derralf\Elements\ImageTeaser\Model\ElementImageTeaser:
  title_tag_default: 'h2'
  title_tag_variants:
    '': 'default'
    h2 : 'H2'
    h3 : 'H3'
    h4 : 'H4'
  use_subtitle: true
  readmore_link_class: 'btn btn-primary btn-readmore'
  styles:
    default: 'default'
    grey: 'grau'
    primary: 'petrol'
    primary-dark: 'petrol dunkel'
    secondary: 'grün'
    white-no-border: 'weiß ohne outliner'
```

Additionally you may apply the default styles:

```
# add default styles
DNADesign\Elemental\Controllers\ElementController:
  default_styles:
    # boptstrap 3 example styles
    - derralf/elemental-image-teaser:client/dist/styles/frontend-default.css
    # boptstrap 4 example styles
    - derralf/elemental-image-teaser:client/dist/styles/frontend-bootstrap-4-example.css
```

See Elemental Docs for [how to disable the default styles](https://github.com/dnadesign/silverstripe-elemental#disabling-the-default-stylesheets).

### Adding your own templates

You may add your own templates/styles like this:

```
Derralf\Elements\ImageTeaser\Element\ElementImageTeaserHolder:
  styles:
    MyCustomTemplate: "new customized special Layout"
```

...and put a template named `ElementImageTeaserHolder_MyCustomTemplate.ss`in `themes/{your_theme}/templates/Derralf/Elements/ImageTeaser/Element/`  
**and/or**
add styles for `. derralf__elements__imageteaser__element__elementimageteaserholder.mycustomtemplate` to your style sheet



## Template Notes

Included templates are based on Bootstrap 3+ but require extra/additional styling (see included stylesheet).

- Optionaly, you can require basic CSS stylings provided with this module to your controller class like:
  **mysite/code/PageController.php**
  ```
      Requirements::css('derralf/elemental-image-teaser:client/dist/styles/frontend-default.css');
  ```
  or copy over and modify `client/src/styles/frontend-default.scss` in your theme scss


## Screen Shots

(not available)


