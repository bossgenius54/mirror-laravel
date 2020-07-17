<div class="modal fade bs-example-modal-xl" id="positionModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModal" aria-hidden="true" style="display: none;">

        <div class="modal-dialog modal-xl" style="max-width:1000px">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Окно выбора позиции</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body" style="text-align: center;">
                    <div class="table-responsive text-center">
                        <table class="table  table-hover color-table muted-table" >
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Ассортимент</th>
                                    <th>Системный номер</th>
                                    <th>Стоимость<br/> Розница </th>
                                    <th>Стоимость<br/> Оптовая</th>
                                    <th>Срок годности</th>
                                    <th>
                                        Выбрано - <input type="number" class="count form-control" value="0" style="display: inline-block;width:100px;" /> шт
                                        <br>из <span class="total_count"></span>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="modal-tbody">
                                <th>
                                    <td colspan="7">Подождите...</td>
                                </th>
                            </tbody>
                        </table>
                    </div>
                </div>
                <form action="{{$addBasket}}" method="POST" id="add-basket">

                    <div class="modal-footer" style="justify-content: space-around;">
                        <button type="button" class="btn btn-default waves-effect col-md-5" data-dismiss="modal" id="return">Отмена</button>
                        <button type="button" class="btn btn-success waves-effect waves-light col-md-5" id="confirm">Добавить</button>
                        <button type="button" class="btn btn-success waves-effect waves-light col-md-5" id="send" style="display: none;">Подтвердить</button>
                    </div>

                </form>

            </div>
        </div>

</div>
