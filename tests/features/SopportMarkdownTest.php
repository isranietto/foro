<?php


class SopportMarkdownTest extends FeatureTestCase
{
    /** @test **/
    function test_the_post_content_support_markdown()
    {
        $importantText = 'Un texto muy importante';

        $post  = $this->createPost([
            'content' => "La primera parte del texto. **$importantText**. La última parte del texto"
        ]);

        $this->visit($post->url)
            ->seeInElement('strong', $importantText);

    }

    /** @test */
    function test_the_code_in_the_post_is_escaped()
    {
        $xssAttack = "<script>alert('Sharing code)</script>";

        $post = $this->createPost([
            'content' => "`$xssAttack`. Texto Normal",
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto Normal')
            ->seeText($xssAttack);
    }

    /** @test */
    function test_xss_attack()
    {
        $xssAttack = "<script>alert('Malicious JS')</script>";

        $post = $this->createPost([
            'content' => "$xssAttack. Texto Normal",
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto Normal')
            ->seeText($xssAttack);
    }

    /** @test */
    function test_xss_attack_with_html()
    {
        $xssAttack = "<img src='img.jpg'>";

        $post = $this->createPost([
            'content' => "$xssAttack. Texto Normal",
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack);
    }
    /** @test **/
    function test_the_post_comment_support_markdown()
    {
        $title = 'Lo puedes encontrar en styde.net';
        $link = 'styde.net';

        $post  = $this->createPost([
            'content' => "### $title.\n Todo lo que busques de Laravel lo puedes encontrar en [$link](https://styde.net)"
        ]);
        
        $this->visit($post->url)
            ->seeInElement('h3', $title)
            ->seeInElement('a', $link);
    }
}
