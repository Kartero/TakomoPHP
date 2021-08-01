<?php
namespace Test\Unit\Takomo\Core\Tools;

use Takomo\Core\Tools\TemplateLoader;
use Test\Unit\Takomo\Core\AbstractTest;

class TemplateLoaderTest extends AbstractTest
{
    private TemplateLoader $templateLoader;

    protected function setUp(): void
    {
        $this->templateLoader = new TemplateLoader();
    }

    public function testParsing() : void
    {
        $templates = [
            'test_base' => VIEW_PATH . '/test_base.html',
            'test_item' => VIEW_PATH . '/test_item.html',
            'child_template' => VIEW_PATH . '/child_template.html',
            'third_dimension' => VIEW_PATH . '/third_dimension.html'
        ];
        $variables = [
            'test_content' => 'XXXXX',
            'child_var' => 'YYYYY',
            'test_list' => [
                [
                    'item_title' => 'ZZZZZ'
                ],
                [
                    'item_title' => 'FFFFF'
                ]
            ]
        ];

        $result = file_get_contents($templates['test_base']);
        unset($templates['test_base']);
        $result = $this->templateLoader->parseBlocks($result, $templates);
        $result = $this->templateLoader->parseVariables($result, $variables, $templates);

        $this->assertStringContainsString('XXXXX', $result);
        $this->assertStringContainsString('YYYYY', $result);
        $this->assertStringContainsString('ZZZZZ', $result);
        $this->assertStringContainsString('FFFFF', $result);
        $this->assertStringContainsString('AAAAA', $result);
    }
}