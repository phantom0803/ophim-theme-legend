<div class="list-movie-filter" style="margin-bottom: 10px;">
    <div class="list-movie-filter-main">
        <form id="form-filter" class="form-inline" method="GET">
            <div class="list-movie-filter-item">
                <label for="filter-sort">Sắp xếp</label>
                    <select class="form-control" id="sort" name="filter[sort]" form="form-search">
                        <option value="">Sắp xếp</option>
                        <option value="update" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'update') selected @endif>Thời gian cập nhật</option>
                        <option value="create" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'create') selected @endif>Thời gian đăng</option>
                        <option value="year" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'year') selected @endif>Năm sản xuất</option>
                        <option value="view" @if (isset(request('filter')['sort']) && request('filter')['sort'] == 'view') selected @endif>Lượt xem</option>
                    </select>
            </div>
            <div class="list-movie-filter-item">
                <label for="filter-sort">Định dạng</label>
                    <select class="form-control" id="type" name="filter[type]" form="form-search">
                        <option value="">Mọi định dạng</option>
                        <option value="series" @if (isset(request('filter')['type']) && request('filter')['type'] == 'series') selected @endif>Phim bộ</option>
                        <option value="single" @if (isset(request('filter')['type']) && request('filter')['type'] == 'single') selected @endif>Phim lẻ</option>
                    </select>
            </div>
            <div class="list-movie-filter-item">
                <label for="filter-sort">Quốc gia</label>
                    <select class="form-control" name="filter[region]" form="form-search">
                        <option value="">Tất cả quốc gia</option>
                        @foreach (\Ophim\Core\Models\Region::fromCache()->all() as $item)
                            <option value="{{ $item->id }}" @if ((isset(request('filter')['region']) && request('filter')['region'] == $item->id) ||
                                (isset($region) && $region->id == $item->id)) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                   </select>
            </div>
            <div class="list-movie-filter-item">
                <label for="filter-sort">Năm</label>
                    <select class="form-control" name="filter[year]" form="form-search">
                        <option value="">Tất cả năm</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" @if (isset(request('filter')['year']) && request('filter')['year'] == $year) selected @endif>
                                {{ $year }}</option>
                        @endforeach
                    </select>
            </div>

            <div class="list-movie-filter-item">
                <label for="filter-sort">Thể loại</label>
                    <select class="form-control" id="category" name="filter[category]" form="form-search">
                        <option value="">Tất cả thể loại</option>
                        @foreach (\Ophim\Core\Models\Category::fromCache()->all() as $item)
                            <option value="{{ $item->id }}" @if ((isset(request('filter')['category']) && request('filter')['category'] == $item->id) ||
                                (isset($category) && $category->id == $item->id)) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
            </div>
            <button type="submit" form="form-search" class="btn btn-red btn-filter-movie"><span>Lọc phim</span></button>

            <div class="clear"></div>
        </form>
    </div>
</div>
