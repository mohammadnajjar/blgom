@extends('layouts.app')

@section('content')
    <div class="col-lg-9 col-12">
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{$post->title}}</td>
                        <td>
                            <a href="{!!route('users.show.comments',['post'=>$post->id])!!}">{{$post->comments_count}}</a>

                        </td>
                        <td>{{$post->post_status}}</td>
                        <td>
                            <a href="{{ route('users.edit.post', $post->id) }}"
                               class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0);"
                               onclick="if (confirm('Are you sure to delete this post?') ) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }"
                               class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('users.post.destroy', $post->id) }}" method="post"
                                  id="post-delete-{{ $post->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                    </tr>
                @empty
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">{!! $posts->links() !!}</td>
                </tr>
                </tfoot>
            </table>
        </div>

    </div>
    @include('partial.frontend.users.sidebar')
@endsection
