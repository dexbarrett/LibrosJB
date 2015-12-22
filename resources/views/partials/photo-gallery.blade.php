@if($book->photos->count() > 0)
    @foreach($book->photos->chunk(3) as $photoRow)
        @foreach($photoRow as $photo)
            <div class="col-md-4 text-center photo-column">
                <a href="/{{ $photo->photo_path }}" class="fancybox" rel="photo-gallery">
                    <img src="/{{ $photo->thumbnail_path }}" alt="" class="photo-thumbnail">
                </a>
            </div>
        @endforeach
    @endforeach
@endif