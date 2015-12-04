<div class="comment">
  <div class="comment-heading">
    @if($comment->children()->count() > 0) <button role="button" class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#comment-{{ $comment->id }}"><span class="caret"></span></button> @endif
    <strong>{{ $comment->user->username }}</strong>
    {{ HTML::linkRoute('vote', '[+]', [$comment->id,1], []) }} -
    {{ HTML::linkRoute('vote', '[-]', [$comment->id,0], []) }} -
    {{ $comment->positiveVotes()->count() - $comment->negativeVotes()->count() }} / {{ $comment->votes()->count() }}
    <button class="btn btn-default btn-sm" type="button" data-toggle="collapse" data-target="#reply-{{ $comment->id }}">Yanıtla</button>
    @if(Auth::check())
      @if($comment->user_id == Auth::user()->id)
         - <small>{{ HTML::linkRoute('post.delete', 'Gönderiyi Sil', [$comment->id], ['class' => 'post-link']) }}</small>
      @endif
    @endif
  </div>
  <div class="comment-content">
    <p>{{ $comment->content }}</p>
  </div>
  <div class="comment-reply collapse" id="reply-{{ $comment->id }}" aria-expanded="true">
    {{ Form::open(['/']) }}
      {{ Form::textarea('content',null,['placeholder' => 'Yorum','class' => 'form-control']) }}<br />
      {{ Form::hidden('comment_id',$comment->id) }}
      {{ Form::submit('Yanıtla',['class' => 'btn btn-lg btn-success'] )}}
    {{ Form::close() }}
  </div>
  <div class="comment-body collapse" id="comment-{{ $comment->id }}" aria-expanded="true">
    @if($comment->children()->count() > 0)
      @foreach($comment->children()->get() as $comment)
        @include('partials.comment')
      @endforeach
    @endif
  </div>
</div>
