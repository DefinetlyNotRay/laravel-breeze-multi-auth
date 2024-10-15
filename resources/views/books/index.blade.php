@if($category)
    <h1>Books in the {{ $category }} category</h1>
    <!-- Display books based on category -->
@else
    <h1>All Books</h1>
    <!-- Display all books -->
@endif