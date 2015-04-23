<?php
App::uses('AppHelper', 'View/Helper');
class TinyMCEHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

	public function __construct($view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->Html->script('tiny_mce/tiny_mce.js', array('inline' => false));
		$this->Html->script('tinymcestatus', array('inline' => false));
	}
	private function __init($element = null, $settings = array(), $ajax = null) {
		$defaults = array(
			"theme" => "advanced",
		    "mode" => "textareas",
		    "plugins" => "save,print,insertdatetime,autosave",
		    "elements" => $element,
		    "theme_advanced_toolbar_location" => "top",
		    "theme_advanced_buttons1" => "save,cancel,print,|,formatselect,cut,copy,paste,undo,|,bold,italic,underline,strikethrough,|,"
									    . "justifyleft,justifycenter,justifyright,justifyfull,|,"
									    . "bullist,numlist,outdent,indent"
									    . "|,undo,redo,separator",
		    "theme_advanced_buttons2" => "",
		    "theme_advanced_buttons3" => "",
		    "height" => "500px",
		    "width" => "940px",
		    "convert_urls" => false,
	        "theme_advanced_buttons1_add" => "insertdate,inserttime",
	        "plugin_insertdate_dateFormat" => "%Y-%m-%d",
	        "plugin_insertdate_timeFormat" => "%H:%M:%S",
	        "save_enablewhendirty" => true,
	        "theme_advanced_toolbar_location" => "top",
        	"theme_advanced_toolbar_align" => "left",
        	"theme_advanced_statusbar_location" => "bottom",
        	"theme_advanced_path" => false,
        	"init_instance_callback" => "interval"


		);

		if($ajax !== null)
			$defaults['save_onsavecallback'] = 'ajaxSave';

		$defaults = array_merge($defaults, $settings);


		$json = json_encode($defaults);

		if($ajax === null)
			$code = 'tinyMCE.init(' . $json . ');';
		else {
			$ajaxCode = '
function ajaxSave() {
		var ed = tinyMCE.get(\'' . $element . '\');
		if (ed.isDirty()) {
	        // Do you ajax call here, window.setTimeout fakes ajax call
	        setEditorStatus(\'' . __('Saving…') . '\');
	        ed.setProgressState(1); // Show progress
	        $.post(\'' .$ajax . '\', { Meeting : { comments : ed.getContent() } } ,function(data) {
	                if (data.code == 200) {
	                	var d = new Date();
						setEditorStatus(\'' . __('Last Saved: ') . ' \' + d);
	       			} else {
	       				alert(\'' . __('There was an error saving…') . '\');
	       			}
	                ed.setProgressState(0); // Hide progress
	                ed.isNotDirty = true;

	        });
     	} else {
     		return false;
 		}
}';
			$code = $ajaxCode . 'tinyMCE.init(' . $json . ');';
		}


		return $this->Html->scriptBlock($code);
	}

	public function editor($input, $data = array(), $settings = array()) {
		if (isset($settings['ajax'])) {
			$ajax = $settings['ajax'];
			unset($settings['ajax']);
		} else {
			$ajax = null;
		}
		$id = sha1(rand() . microtime(true));
		$data['id'] = $id;
		$data['label'] = false;
		$data['control_group'] = false;

		$return = $this->Form->input(
			$input,
			$data
		);
		$this->Form->unlockField($input);
		$return .= $this->__init($id, $settings, $ajax);
		return $return;
	}

}