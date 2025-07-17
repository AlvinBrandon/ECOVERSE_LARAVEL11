<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ChatRoutesTest extends TestCase
{
    /**
     * Test all chat routes to ensure they're responding correctly
     *
     * @return void
     */
    public function test_chat_routes_are_accessible()
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        $this->actingAs($user);
        
        // Test main chat page
        $response = $this->get('/chat');
        $response->assertStatus(200);
        
        // Test chat history
        $response = $this->get('/chat/history');
        $response->assertStatus(200);
        
        // Test start chat page
        $response = $this->get('/chat/start');
        $response->assertStatus(200);
        
        // Test polling routes
        $routes = [
            '/chat/poll/messages',
            '/chat/poll/online-users',
            '/chat/poll/unread-count'
        ];
        
        foreach ($routes as $route) {
            $response = $this->get($route);
            $statusCode = $response->getStatusCode();
            
            // Either 200 or 422 (validation error) are acceptable as it shows the route exists
            $this->assertTrue(
                in_array($statusCode, [200, 422]),
                "Route $route returned $statusCode"
            );
        }
    }
}
