<!DOCTYPE html>
<html>
  <head>
    <title>Tìm Kiếm</title>
  </head>
  <body>
    <form action="{{route('ketqua')}}" method="GET">
      <div class="form-group">
        <label for="search">Search: </label>
        <input type="text" name="search">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
  </body>
</html>