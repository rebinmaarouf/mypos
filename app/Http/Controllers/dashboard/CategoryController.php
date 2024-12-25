<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->latest()->paginate(5);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = ['required', function ($attribute, $value, $fail) use ($locale) {
                // Check for duplicates in the database for the current locale
                $exists = Category::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.\"$locale\".name')) = ?", [$value])
                    ->exists();

                if ($exists) {
                    // Use dynamic locale-based translation keys for custom messages
                    $fail(__('site.' . $locale . '.unique')); // Ensure the locale is used here
                }
            }];
        }

        // Validate the request based on the rules
        $validatedData = $request->validate($rules);

        // Prepare data for creation
        $categoryData = $request->only(config('translatable.locales'));

        // Create the category
        Category::create([
            'name' => $categoryData,
        ]);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }




    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Category $category)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = ['required', function ($attribute, $value, $fail) use ($locale, $category) {
                // Check for duplicates in the database for the current locale, excluding the current category
                $exists = Category::where('id', '!=', $category->id) // Exclude current category by ID
                    ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.\"$locale\".name')) = ?", [$value]) // Check the value for the specific locale
                    ->exists();

                if ($exists) {
                    // Use dynamic locale-based translation keys for custom messages
                    $fail(__('site.' . $locale . '.unique')); // Ensure the locale is used here
                }
            }];
        }

        // Validate the request based on the rules
        $validatedData = $request->validate($rules);

        // Prepare data for updating
        $categoryData = $request->only(config('translatable.locales'));
        $category->update([
            'name' => $categoryData,
        ]);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }
}
