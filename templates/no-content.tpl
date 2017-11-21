<div id="headerwrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>Send your authors
                    <br/>and books to an incredible API</h1>
                <form class="form-inline" role="form" action="/upload" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" data-filename-placement="inside" accept=".json,.csv" required/>
                        <button type="submit" class="btn btn-warning btn-lg">Send</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <img class="img-responsive" src="assets/img/ipad-hand.png" alt="">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt centered">
        <h1>Lastest Authors</h1>
        <table class="table">
            <thead>
                <tr role="row">
                    <th role="columnheader">Name</th>
                    <th role="columnheader">Last Name</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN ROW -->
                {lastestAuthors}
                <!-- END ROW -->
            </tbody>
        </table>
    </div>
</div>
