<?php
/**
 * Obfuscates email addresses.
 * 
 * @author     Allan Boll
 */

class syntax_plugin_emailobfuscator extends DokuWiki_Syntax_Plugin {
    public function getType() { return 'substition'; }
    public function getSort() { return 32; }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}', $mode, 'plugin_emailobfuscator');
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        return array($match, $state, $pos);
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        preg_match('/([A-Za-z0-9._%+-]+)@([A-Za-z0-9.-]+\.[A-Za-z]{2,4})/', $data[0], $matches);

        if($mode == 'xhtml'){
            $renderer->doc .= $matches[1] . '&#64;<span style="display: none;">null</span>' . $matches[2];
        } else {
            $renderer->doc .= $matches[1] . "at _no_spam_please_ " . $matches[2];
        }

        return true;
    }
}
