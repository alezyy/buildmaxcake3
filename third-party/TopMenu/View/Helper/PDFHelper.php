<?php
App::uses('AppHelper', 'View/Helper');
/*
 * PDFHelper
 * Much the same as ImageHelper, but this generates a link
 * to the PDF.
 *
 */
class PDFHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

/**
 * beforeRender - load up our JS before the view renders
 * @param  string $viewFile
 * @return void
 */
    public function beforeRender($viewFile) {
        parent::beforeRender($viewFile);
//        $this->Html->script('file_helper', array('inline' => false));
    }



/**
 * Returns a <a> tag with the link to the pdf.
 * @param  string $id      UUID of the pdf
 * @param  array  $options Any HTML options to pass to HtmlHelper
 * @param  string $label   Title of the link 
 * @return string          <a> tag
 */
    public function out($id, $options = array(), $label = NULL) {
        if (!array_key_exists('style', $options)) {
            $options['style'] = 'margin-right:5px;margin-left:5px;';
        }

        if (!array_key_exists('target', $options)) {
            $options['target'] = '_blank';
        }
		
		$label = ($label === NULL)? __('View PDF Menu'): $label;
		
        return $this->Html->link(
            $label,
            array(
                'controller' => 'pdfs',
                'action' => 'get_pdf',
                'pdf_id' => $id,
                'admin' => false,
                'language' => false,
                'ext' => 'pdf',
            ),
            $options
        );
    }

/**
 * Returns a form element built to handle our PDFs
 * Will automatically include a link and a remove button if there
 * is an existing file
 * @param  string $field  field name
 * @param  array  $option options to pass to FormHelper
 * @return string         Tag to be inserted into the view
 */
    public function input($field, $option = array()) {
        $modelKey = Inflector::singularize($this->_View->name);
        $options = array(
            'type' => 'file'
        );

        $route = Router::parse($this->request->url);

        $admin = false;
        if (array_key_exists('admin', $route)) {
            $admin = $route['admin'];
        }

        $link = array(
            'controller' => $route['controller'],
            'action' => $route['action'],
            'admin' => $admin,
            'delete_pdf' => $field
        );

        foreach ($route['pass'] as $pass) {
            $link[] = $pass;
        }

        if (
            isset($this->request->data[$modelKey][$field])
            && !empty($this->request->data[$modelKey][$field]
        )) {
            $options['prepend'] = $this->out(
                $this->request->data[$modelKey][$field]
            );
            $options['prepend'] .= $this->Html->link(
                'x',
                $link,
                array(
                    'class' => 'btn btn-danger delete-file',
                    'message' =>  __('Are you sure you want to delete this PDF?')
                )
            );
        }
        $options = array_merge($options, $option);
        return $this->Form->input(
            $field,
            $options
        );
    }



}