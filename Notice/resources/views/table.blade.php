<table id="table_notices" class="table table-hover tablenotices">
    <thead class="thead-white">
        <tr>
            <th scope="col">
                <h3 class="title-not">Notices:</h3>
            </th>
            <th colspan="2">
              <a class="btn-action align-self-center buttonlink" href="/notices/view/create" data-toggle="tooltip" data-placement="top" title="New notice">
                  <div class="info text-center">
                      <i class="far fa-sticky-note fa-3x"></i>
                  </div>
              </a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($notices as $n)
         <tr scope="row">
            <td>
                <a class="btn-action align-self-center" href="/notices/{{$n['id']}}">
                    <h6 class="text-muted">{{$n['title']}}</h6>
                </a>
            </td>
            <td width="30">
                <div class="d-flex justify-content-around">
                    <a class="btn-action align-self-center buttonlink" href="/notices/{{$n['id']}}/edit" data-toggle="tooltip" data-placement="top" title="Edit">
                        <i class="fas fa-edit fa-lg"></i>
                    </a>
                </div>
            </td>
            <td width="30">
                <div class="d-flex justify-content-around">
                    <a class="btn-action align-self-center buttonlink del" onclick="deleteNotice('{{$n['id']}}')" href="#" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i class="fas fa-trash fa-lg"></i>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
