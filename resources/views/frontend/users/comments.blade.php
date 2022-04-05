@extends('layouts.app')

@section('content')
    <div class="col-12">
        <!-- Start Blog Area -->
        <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-12">
                        <div class="table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Post</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($comments as $comment)
                                    <tr>
                                        <td>{{$comment->name}}</td>
                                        <td>{{$comment->post->title}}</td>
                                        <td>{{$comment->comment_status}}</td>
                                        <td>
                                            <a href="{{ route('users.edit.comment', $comment->id) }}"
                                               class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0);"
                                               onclick="if (confirm('Are you sure to delete this comment?') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }"
                                               class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                            <form action="{{ route('users.comment.destroy', $comment->id) }}"
                                                  method="post" id="comment-delete-{{ $comment->id }}"
                                                  style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4">{!! $comments->links() !!}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    @include('partial.frontend.users.sidebar')

                </div>
            </div>
        </div>

    </div>
    <!-- End Blog Area -->
@endsection
