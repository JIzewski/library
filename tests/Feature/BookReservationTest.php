<?php

namespace Tests\Feature;

use App\Models\Book;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    //clears in-memory database for each test. 
    use RefreshDatabase;

     /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        //avoid http resposne to prevent http errors 
        $this->withoutExceptionHandling();

        //Test response
        $response = $this->post('/books' , [

            'title' => 'Cool Books Title', 
            'author' => 'Cool Book Author', 
        ]);

        //Ensure response is valid
        $response->assertOk();

        $this->assertCount(1, Book::all());


    }

     /** @test */
     public function a_title_is_required()
     {
        //avoid http resposne to prevent http errors 
       // $this->withoutExceptionHandling();

        //Test response
        $response = $this->post('/books' , [

            'title' => '', 
            'author' => 'Cool Book Author', 
        ]);

        //Ensure response is valid
        $response->assertSessionHasErrors('title');

       // $this->assertCount(1, Book::all());


     }

      /** @test */
      public function a_author_is_required()
      {
         //avoid http resposne to prevent http errors 
        // $this->withoutExceptionHandling();
 
         //Test response
         $response = $this->post('/books' , [
 
             'title' => 'A Cool Book Title',
             'author' => '', 
         ]);
 
         //Ensure response is valid
         $response->assertSessionHasErrors('author');
 
        // $this->assertCount(1, Book::all());
 
 
      }

       /** @test */
       public function a_book_can_be_updated()
       {

        $this->withoutExceptionHandling();
  
       
          $this->post('/books' , [
    
                'title' => 'A Cool Book Title',
                'author' => 'A Cool Author', 
            ]);

            $book = Book::first();

            $response = $this->patch('/books/' . $book->id , [

                'title' => 'New Title', 
                'author' => 'New Author', 

            ]);

            $this->assertEquals('New Title', Book::first()->title);
            $this->assertEquals('New Author', Book::first()->author);
  
        
  
       }


}