<div class="container">
    <?php if (isset($videos)):?>
        <div class="row">
            <?php foreach ($videos as $video):?>
                <div class="container video col-9 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <div class="container video-data">
                        <div class="image">
                            <a data-fancybox href="https://www.youtube.com/embed/<?=$video["idVideo"]?>"><img src="<?=$video['preview']?>" alt="<?=$video["title"]?>"/></a>
                            <a id="removelikebutton" data-id="<?=$video["idVideo"]?>" data-title="<?=$video["title"]?>" data-preview="<?=$video['preview']?>" data-publishedAt="<?=$video["publishedAt"]?>"><i class="fas fa-thumbs-up"></i></a>
                        </div>
                        <p class="title-video"><?=$video["title"]?></p>
                        <p> <small class="publishedAt-video">Опубликовано: <?=$video["publishedAt"]?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="container button">
        <a id="prevPage" class="btn btn-dark mr-auto">Предыдущая страница</a>
        <a id="nextPage" class="btn btn-dark mr-auto">Следующая страница</a>
    </div>
</div>