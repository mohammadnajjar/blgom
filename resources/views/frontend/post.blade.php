@extends('layouts.app')

@section('content')
    <div class="page-blog-details section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-details content">
                        <article class="blog-post-details">
                            <div class="post-thumbnail">
                                @if($post->media->count()>0)
                                    <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @foreach($post->media as $media)
                                                <li data-target="#carouselIndicators" data-slide-to="{{$loop->index}}"
                                                    class="{{$loop->index==0?'active':''}}"></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach($post->media as $media)
                                                <div class="carousel-item {{$loop->index==0?'active':''}}">
                                                    <img class="d-block w-100" src="{{asset('assets/posts/'
                                                .$media->file_name)}}"
                                                         alt="{{$post->title}}">
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($post->media->count()>1)
                                            <a class="carousel-control-prev" href="#carouselIndicators" role="button"
                                               data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselIndicators" role="button"
                                               data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="post_wrapper">
                                <div class="post_header">
                                    <h2>{{$post->title}}</h2>
                                    <div class="blog-date-categori">
                                        <ul>
                                            <li>{{$post->created_at->format("M d Y")}}</li>
                                            <li><a href="{{route('frontend.author.post',$post->user->username)}}"
                                                   title="Posts by boighor"
                                                   rel="author">{{$post->user->name}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post_content">
                                    <p>{!! $post->description !!}</p>

                                </div>
                                <ul class="blog_meta">
                                    <li><a href="#">{{$post->approved_comments->count()}} comments</a></li>
                                    <li> /</li>
                                    <li>Category:<span> {{$post->category->name}}</span></li>
                                </ul>
                            </div>
                        </article>
                        <div class="comments_area">
                            <h3 class="comment__title">{{$post->approved_comments->count()}} comment</h3>
                            <ul class="comment__list">
                                @forelse($post->approved_comments as $comment)
                                    <li>
                                        <div class="wn__comment">
                                            <div class="thumb">
                                                <img src="{{get_gravatar($comment->email,46)}}"
                                                     alt="comment images">
                                            </div>
                                            <div class="content">
                                                <div class="comnt__author d-block d-sm-flex">
                                                    <span><a href="{{$comment->url !="" ? $comment->url :'#'
                                                    }}">{{$comment->name}}</a></span>
                                                    <span>{{$comment->created_at->format('M d Y h:i a')}}</span>
                                                </div>
                                                <p>{{$comment->comment}}</p>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    No Coomment Found
                                @endforelse
                            </ul>
                        </div>
                        <div class="comment_respond">
                            <h3 class="reply_title">Leave a Reply <small><a href="#">Cancel reply</a></small></h3>
                            {!! Form::open(['route' => ['post.add_comment', $post->slug,],'method'=>'post','class'=>'comment__form'])
                             !!}

                            <p>Your email address will not be published.Required fields are marked </p>
                            <div class="input__box">
                                {!! Form::textarea('comment',old('comment'),['placeholder'=>'Your comment here']) !!}
                                @error('comment')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="input__wrapper clearfix">
                                <div class="input__box name one--third">
                                    {!!       Form::text('name',old('name'),['placeholder'=>'Your name here']) !!}
                                    @error('name')<span class="text-danger">{{$message}}</span>@enderror

                                </div>
                                <div class="input__box email one--third">
                                    {!!       Form::email('email',old('email'),['placeholder'=>'Your email here']) !!}
                                    @error('email')<span class="text-danger">{{$message}}</span>@enderror

                                </div>
                                <div class="input__box website one--third">
                                    {!!       Form::text('url',old('url'),['placeholder'=>'Your url here']) !!}
                                    @error('url')<span class="text-danger">{{$message}}</span>@enderror

                                </div>
                            </div>
                            <div class="submite__btn">

                                {!! Form::submit('Post Comment' ,['class'=>"btn btn_primary"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                    <div class="wn__sidebar">
                        <!-- Start Single Widget -->
                        <aside class="widget search_widget">
                            <h3 class="widget-title">Search</h3>
                            <form action="#">
                                <div class="form-input">
                                    <input type="text" placeholder="Search...">
                                    <button><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </aside>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget recent_widget">
                            <h3 class="widget-title">Recent</h3>
                            <div class="recent-posts">
                                <ul>
                                    <li>
                                        <div class="post-wrapper d-flex">
                                            <div class="thumb">
                                                <a href="blog-details.html"><img
                                                        src="{{asset('frontend/images/blog/sm-img/1.jpg')}}"
                                                        alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Blog image post</a></h4>
                                                <p> March 10, 2015</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="post-wrapper d-flex">
                                            <div class="thumb">
                                                <a href="blog-details.html"><img
                                                        src="{{asset('frontend/images/blog/sm-img/1.jpg')}}"
                                                        alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Post with Gallery</a></h4>
                                                <p> March 10, 2015</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="post-wrapper d-flex">
                                            <div class="thumb">
                                                <a href="blog-details.html"><img
                                                        src="{{asset('frontend/images/blog/sm-img/1.jpg')}}"
                                                        alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Post with Video</a></h4>
                                                <p> March 10, 2015</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="post-wrapper d-flex">
                                            <div class="thumb">
                                                <a href="blog-details.html"><img
                                                        src="{{asset('frontend/images/blog/sm-img/1.jpg')}}"
                                                        alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Maecenas ultricies</a></h4>
                                                <p> March 10, 2015</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="post-wrapper d-flex">
                                            <div class="thumb">
                                                <a href="blog-details.html"><img
                                                        src="{{asset('frontend/images/blog/sm-img/1.jpg')}}"
                                                        alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">Blog image post</a></h4>
                                                <p> March 10, 2015</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </aside>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget comment_widget">
                            <h3 class="widget-title">Comments</h3>
                            <ul>
                                <li>
                                    <div class="post-wrapper">
                                        <div class="thumb">
                                            <img src="{{asset('frontend/images/blog/comment/1.jpeg')}}"
                                                 alt="Comment images">
                                        </div>
                                        <div class="content">
                                            <p>demo says:</p>
                                            <a href="#">Quisque semper nunc vitae...</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-wrapper">
                                        <div class="thumb">
                                            <img src="{{asset('frontend/images/blog/comment/1.jpeg')}}"
                                                 alt="Comment images">
                                        </div>
                                        <div class="content">
                                            <p>Admin says:</p>
                                            <a href="#">Curabitur aliquet pulvinar...</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-wrapper">
                                        <div class="thumb">
                                            <img src="{{asset('frontend/images/blog/comment/1.jpeg')}}"
                                                 alt="Comment images">
                                        </div>
                                        <div class="content">
                                            <p>Irin says:</p>
                                            <a href="#">Quisque semper nunc vitae...</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-wrapper">
                                        <div class="thumb">
                                            <img src="{{asset('frontend/images/blog/comment/1.jpeg')}}"
                                                 alt="Comment images">
                                        </div>
                                        <div class="content">
                                            <p>Boighor says:</p>
                                            <a href="#">Quisque semper nunc vitae...</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-wrapper">
                                        <div class="thumb">
                                            <img src="{{asset('frontend/images/blog/comment/1.jpeg')}}"
                                                 alt="Comment images">
                                        </div>
                                        <div class="content">
                                            <p>demo says:</p>
                                            <a href="#">Quisque semper nunc vitae...</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </aside>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget category_widget">
                            <h3 class="widget-title">Categories</h3>
                            <ul>
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Creative</a></li>
                                <li><a href="#">Electronics</a></li>
                                <li><a href="#">Kids</a></li>
                                <li><a href="#">Flower</a></li>
                                <li><a href="#">Books</a></li>
                                <li><a href="#">Jewelle</a></li>
                            </ul>
                        </aside>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget archives_widget">
                            <h3 class="widget-title">Archives</h3>
                            <ul>
                                <li><a href="#">March 2015</a></li>
                                <li><a href="#">December 2014</a></li>
                                <li><a href="#">November 2014</a></li>
                                <li><a href="#">September 2014</a></li>
                                <li><a href="#">August 2014</a></li>
                            </ul>
                        </aside>
                        <!-- End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
