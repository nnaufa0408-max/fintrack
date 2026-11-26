<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    public function index() { $categories=Category::where('user_id',Auth::id())->withCount('transactions')->orderBy('name')->get(); return view('categories.index',compact('categories')); }
    public function create() { return view('categories.create'); }
    public function store(Request $request) { $data=$this->validated($request); Category::create($data+['user_id'=>Auth::id()]); return redirect()->route('kategori.index')->with('success','Kategori berhasil ditambahkan.'); }
    public function edit(Category $category) { $this->owner($category); return view('categories.edit',compact('category')); }
    public function update(Request $request, Category $category) { $this->owner($category); $category->update($this->validated($request)); return redirect()->route('kategori.index')->with('success','Kategori diperbarui.'); }
    public function destroy(Category $category) { $this->owner($category); $category->delete(); return back()->with('success','Kategori dipindahkan ke soft-delete.'); }
    private function validated(Request $request): array { return $request->validate(['name'=>['required','string','max:60'],'type'=>['required','in:income,expense'],'color'=>['required','string','max:20']]); }
    private function owner(Category $category): void { abort_unless($category->user_id===Auth::id(),403); }
}
