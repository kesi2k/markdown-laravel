<?php

namespace Tests\Feature;

use Tests\TestCase;

class EndpointTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_two_hashtags_one_line(): void
    {
        $response = $this->post('http://127.0.0.1:8000/markdown/post', [
            "message" => '## Hello',
        ]);

        $response->assertStatus(200);
        $response->assertSee("<h2>Hello</h2>");
    }

    public function test_two_consecutive_lines_with_same_tag(): void
    {
        $response = $this->post('http://127.0.0.1:8000/markdown/post', [
            "message" => "# Header one\nHow are you?\nWhat's going on?"
        ]);

        $response->assertStatus(200);
        $response->assertSee("<p>How are you?");
    }

    public function test_two_lines_with_same_tag_space_between(): void
    {
        $response = $this->post('http://127.0.0.1:8000/markdown/post', [
            "message" => "# Header one\nHow are you?\n\nWhat's going on?"
        ]);

        $response->assertStatus(200);
        $response->assertSee("How are you?</p>");
    }

    public function test_header_with_a_link(): void
    {
        $response = $this->post('http://127.0.0.1:8000/markdown/post', [
            "message" => "### This is a header [with a link](http://yahoo.com)"
        ]);

        $response->assertStatus(200);
        $response->assertSee('<h3>This is a header <a href="http://yahoo.com">with a link</a></h3>');
    }

    public function test_paragraph_with_a_link(): void
    {
        $response = $this->post('http://127.0.0.1:8000/markdown/post', [
            "message" => "This is a paragraph [with an inline link](http://google.com). Neat, eh?"
        ]);

        $response->assertStatus(200);
        $response->assertSee('<p>This is a paragraph <a href="http://google.com">with an inline link</a>. Neat, eh?</p>');
    }

    public function test_closing_tag_last_line(): void
    {
        $response = $this->post('http://127.0.0.1:8000/markdown/post', [
            "message" => "Hello there\nHow are you?\nWhat's going on?"
        ]);

        $response->assertStatus(200);
        $response->assertSee('What\'s going on?</p>');
    }

    
}
