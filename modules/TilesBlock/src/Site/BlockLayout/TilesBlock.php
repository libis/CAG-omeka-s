<?php
namespace TilesBlock\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Stdlib\HtmlPurifier;
use Omeka\Stdlib\ErrorStore;
use Zend\Form\Element\Textarea;
use Zend\View\Renderer\PhpRenderer;

/**
 * The block layout class encapsulates everything about your custom block.
 *
 * Everything the user sees about your block, both on the admin and public
 * sides, gets defined here.
 */
class TilesBlock extends AbstractBlockLayout
{
    /**
     * getLabel() is where you define the label users will see when selecting
     * your block.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Tiles'; // @translate
    }

    /**
     * The form() method is where the form for your block is defined.
     *
     * You can use the following helpers here for some common pieces of
     * the block form interface:
     *
     * - $view->blockAttachmentsForm($block) (to select items and media)
     * - $view->blockThumbnailTypeSelect($block) (to select the "size" of images to show)
     * - $view->blockShowTitleSelect($block) (to select where displayed attachment titles should come from)
     *
     * You can use form elements more or less as usual here, but you'll
     * want to take care with the names of your form elements: the form
     * expects all your custom elements to have names starting with the
     * following prefix:
     *
     * `o:block[__blockIndex__][o:data]`
     *
     * Anything starting with that prefix will automatically be saved to
     * the block's `data` property.
     *
     * @return string
     */
    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $html = '';
        $html .= $view->blockAttachmentsForm($block);
        $html .= '<h4>Title</h4>
        <div class="field">
          <div class="inputs">
              <input type="text" class="" value="'.(!isset($block) ? '' : $block->dataValue('title')).'" name="o:block[__blockIndex__][o:data][title]">
          </div>
        </div>';
        $html .= '<h4>Text</h4>';
        $textarea = new Textarea("o:block[__blockIndex__][o:data][text]");
        $textarea->setAttribute('class', 'block-html full wysiwyg');
        if ($block) {
            $textarea->setAttribute('value', $block->dataValue('text'));

        }
        $html .= $view->formRow($textarea);
        $html .= '<div class="field">
          <div class="field-meta">
              <label>Link</label>
          </div>
          <div class="inputs">
              <input type="text" class="" value="'.(!isset($block) ? '' : $block->dataValue('link')).'" name="o:block[__blockIndex__][o:data][link]">
          </div>
        </div>';

        if(isset($block)):
          $span = $block->dataValue('span');
        else:
          $span = 4;
        endif;

        $html .='<div class="field">
          <div class="field-meta">
              <label>Span (width of a block)</label>
              <a href="#" class="expand" aria-label="Expand" title="Expand"></a>
              <div class="collapsible">
                <div class="field-description">12 equals full width</div>
              </div>
          </div>
          <div class="inputs">
              <select type="text" class="" name="o:block[__blockIndex__][o:data][span]">
                <option '.($span == 3 ? 'selected' : "").' value="3">3 (1/4)</option>
                <option '.($span == 4 ? 'selected' : "").' value="4">4 (1/3)</option>
                <option '.($span == 6 ? 'selected' : "").' value="6">6 (1/2)</option>
                <option '.($span == 8 ? 'selected' : "").' value="8">8 (2/3)</option>
                <option '.($span == 9 ? 'selected' : "").' value="9">9 (3/4)</option>
                <option '.($span == 12 ? 'selected' : "").' value="12">12 (4/4)</option>
              </select>
          </div>
        </div>';
        if(isset($block)):
          $last = $block->dataValue('last');
        else:
          $last = 0;
        endif;
        $html .= '<div class="field">
          <div class="field-meta">
              <label>Last in row?</label>
              <a href="#" class="expand" aria-label="Expand" title="Expand"></a>
              <div class="collapsible">
                <div class="field-description">This will handle the margins of the last block in a row</div>
              </div>
          </div>
          <div class="inputs">
              <input type="checkbox" class="" value="last" '.($last == 'last' ? 'checked' : '').' name="o:block[__blockIndex__][o:data][last]">
          </div>
        </div>';

        return $html;
    }

    /**
     * render() is pretty much the opposite of form(): it's where you
     * define the output of the block for the public side.
     *
     * This is the heart of a block layout: everything you collect on
     * form will get used here for the display.
     *
     * You'll generally be working with $block here, the block's API
     * representation, which gives you access to all the saved data
     * about the block. In particular, you might use:
     *
     * `$block->attachments()` (returns all attached items/media from the form)
     * `$block->dataValue($key)` (get a saved custom data value)
     *
     * @return string
     */
    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
      $attachments = $block->attachments();
      $alignmentClass = $block->dataValue('alignment', 'left');
      $thumbnailType = $block->dataValue('thumbnail_type', 'square');
      $text =  $block->dataValue('text','');
      $span =  $block->dataValue('span',4);
      $last =  $block->dataValue('last','');
      $title =  $block->dataValue('title','');
      $linkType = $view->siteSetting('attachment_link_type', 'item');
      $showTitleOption = $block->dataValue('show_title_option', 'item_title');

      echo '<div class="tiles-block span-'.$span.' '.$last.'"><div class="item-wrapper">';

      if (!$attachments) {
        if ($text):
            echo '<div class="text-no-image">'.$text.'</div>';
            echo '<a href="'.$block->dataValue('link').'">Read more</a>';
        endif;
      }
      foreach($attachments as $attachment):
          if($title):
            echo "<h3 class='top-title'>".$title."</h3>";
          endif;
          echo '<div class="item resource">';

          $item = $attachment->item();
          if ($item):
              $media = $attachment->media() ?: $item->primaryMedia();
              if ($media):
                  echo '<div class="tiles-img">
                    <a href="'.$block->dataValue('link').'">';
                    if($span =='12'):
                      $thumbnailType = 'large';
                    endif;
                  echo $view->thumbnail($media, $thumbnailType);
                  echo '</a></div>';
              endif;
          endif;

          echo '<div class="text-image">';
          if($title):
            echo "<h3 class='box-title'><span></pan>".$title."</span></h3>";
          endif;
          if ($text):
              echo '<a href="'.$block->dataValue('link').'">'.$text.'</a>';
          endif;
          echo '<div class="tile-more">';
          echo '<a href="'.$block->dataValue('link').'">Read more</a>';
          echo '</div>';

          echo '</div>';

          echo '</div>';
          break;
      endforeach;
      echo '</div></div>';
      /*return $view->partial('common/block-layout/tiles', [
          'block' => $block,
          'attachments' => $attachments,
          'alignmentClass' => $alignmentClass,
          'thumbnailType' => $thumbnailType,
          'link' => $linkType,
          'showTitleOption' => $showTitleOption,
      ]);*/
    }
}
