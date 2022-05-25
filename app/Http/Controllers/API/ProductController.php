<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Cloudinary\Cloudinary;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'admin'], ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => 200,
            'products' => $products->makeHidden(['created_at', 'updated_at'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,bmp,png'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->toJson()
            ], 400);
        }
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . rand(1000, 9999);
            $ext = $file->extension();
            $imgName = $name . "." . $ext;
            $request->image->move(('images'), $imgName);


            $cloudinary = new Cloudinary();
            $folder = "s-food";
            $cloudinary->uploadApi()->upload(public_path('images/' . $imgName), [
                "folder" => $folder,
                "public_id" => $name,
                "format" => $ext
            ]);

            // Save DB image name
            $product->image = $folder . "/" .  $imgName;

            // Delete file in storage after upload
            File::delete("images/" . $imgName);
        }
        $product->save();
        return response()->json([
            'status' => 200,
            'message' => 'Tạo thành công.',
            'product' => $product,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->toJson(),
            ], 400);
        }

        $cloudinary = new Cloudinary();

        $product =  Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;


        if ($request->hasFile('image')) {
            if ($product->image) {
                $cloudinary->uploadApi()->destroy(explode(".", $product->image)[0]);
            }

            $file = $request->file('image');
            $name = time() . rand(1000, 9999);
            $ext = $file->extension();
            $imgName = $name . "." . $ext;
            $request->image->move(('images'), $imgName);


            $folder = "s-food";
            $cloudinary->uploadApi()->upload(public_path('images/' . $imgName), [
                "folder" => $folder,
                "public_id" => $name,
                "format" => $ext
            ]);

            // Save DB image name
            $product->image = $folder . "/" .  $imgName;

            // Delete file in storage after upload
            File::delete("images/" . $imgName);
        }
        $product->save();
        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật thành công.',
            'product' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =  Product::find($id);
        if ($product->image) {

            $cloudinary = new Cloudinary();

            $cloudinary->uploadApi()->destroy(explode(".", $product->image)[0]);
        }
        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Xóa thành công.',
        ]);
    }
}
