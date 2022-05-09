<form action="/search" method="get">
    <input type="text" name="search" class="input" value="{{ request()->search ?? '' }}">

    <input type="submit" class="btn btn-info">
</form>
