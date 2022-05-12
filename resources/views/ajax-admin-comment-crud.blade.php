<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name', 'Laravel')}}</title>
        <!-- Stylesheets -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <!-- Table headings and body -->
    <body>
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12 card-header text-center font-weight-bold">
                    <h1>{{ __('Comment Bank Admin View') }}</h2>
                </div>
                <div id="message"></div>
                <div class="col-md-12 mt-1 mb-2">
                    <button type="button" id="addNewComment" class="btn btn-success">Add</button>
                </div>
                <div class="col-md-12">
                    <table id="Table1" class="table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">#</th>
                                <th scope="col">Type</th>
                                <th scope="col">Comment</th>
                                <th scope="col">Author</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Effect</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <input id="btnGet" type="button" value="Get Selected" />
                    <div>
                        <textarea id="messageList" rows="10" cols="100">Selection</textarea>
                        <button type="button" id="copy">Copy</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of table headings and body -->

        <!-- Boostrap model -->
        <div class="modal fade" id="ajax-comment-model" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-type" id="ajaxCommentModel"></h4>
                    </div>
                    <div class="modal-body">
                        <ul id="msgList"></ul>
                        <form action="javascript:void(0)" id="addEditCommentForm" name="addEditCommentForm" class="form-horizontal" method="POST">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Comment Type</label>
                                <div class="col-sm-12">
                                    <select type="text" class="form-control" id="type" name="type" value="" maxlength="50" required="">
                                        <option value="Intro">Introduction Material</option>
                                        <option value="Term">Terminology</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-5 control-label">Comment Summary</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="comment" name="comment" rows="4" cols="10">Enter Comment Summary</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Author</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="author" name="author" placeholder="Enter name" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">E-mail</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter E-mail Address" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Effect</label>
                                <div class="col-sm-12">
                                    <select type="text" class="form-control" id="effect" name="effect" value="" maxlength="2" required="">
                                        <option value="P">Positive</option>
                                        <option value="N">Negative</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Validated</label>
                                <div class="col-sm-12">
                                    <select type="text" class="form-control" id="validated" name="validated" value="" maxlength="2" required="">
                                        <option value='1'>Approved</option>
                                        <option value='0'>Not Approved</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="btn-add" value="addNewComment">Save
                                </button>
                                <button type="submit" class="btn btn-primary" id="btn-save" value="UpdateComment">Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!-- End bootstrap model -->

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="{{asset('js/admin-control.js')}}"></script>
    </body>
</x-app-layout>