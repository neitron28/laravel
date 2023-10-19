<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Blog Post API", version="1.0")
 * @OA\Server(url="http://localhost:8000")
 *
 * @OA\Tag(
 *     name="Posts",
 *     description="API Endpoints of Post"
 * )
 *
 * @OA\Schema(
 *   schema="Post",
 *   title="Post model",
 *   description="Post model",
 *   @OA\Property(property="id", type="integer", format="int64", example=1),
 *   @OA\Property(property="title", type="string", example="Sample Post Title"),
 *   @OA\Property(property="content", type="string", example="Content of the post here"),
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *      path="/posts",
     *      operationId="getPostsList",
     *      tags={"Posts"},
     *      summary="Get list of blog posts",
     *      description="Returns list of blog posts",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Post"))
     *       ),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * @OA\Post(
     *      path="/posts",
     *      operationId="storePost",
     *      tags={"Posts"},
     *      summary="Store new blog post",
     *      description="Returns post data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful created",
     *          @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     *      @OA\Response(response=422, description="Validation Error"),
     *      @OA\Response(response=500, description="Server error")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([]);

        Post::create($request->all());

        return redirect('/posts')->with('success', 'Post Created Successfully.');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $request->validate([]);

        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $post->update($request->all());

        return redirect('/posts')->with('success', 'Post Updated Successfully.');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted Successfully.');
    }
}
