<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'ProductCreate'}" class="btn btn-success">Create new company</router-link>
        </div>
 
        <div class="panel panel-default">
            <div class="panel-heading">Companies list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Website</th>
                            <th width="100">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items" :key="item.id">
                            <td>{{ item.name }}</td>
                            <td>{{ item.note }}</td>
                            <td>{{ item.color }}</td>
                            <td>
                                <router-link :to="{name: 'ProductEdit', params: {id: item.id}}" class="btn btn-xs btn-default">
                                    Edit
                                </router-link>
                                <a      href="#"
                                        class="btn btn-xs btn-danger"
                                        v-on:click="deleteEntry(item.id)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
 
<script>
export default {
    data: function () {
        return {
            items: []
        }
    },
    mounted() {
        this.getItemList();
    },
    methods: {
        deleteEntry(id) {
            if (confirm("Вы действительно хотите удалить компанию?")) {
                var app = this;
                axios.delete('/json/project/delete/' + id).then(function (resp) {
                    app.getItemList();
                })
                .catch(function (resp) {
                    alert("Не удалось удалить компанию");
                });
            }
        },
        getItemList(){
            var app = this;
            axios.get('/json/project/').then(function (resp) {
                app.items = resp.data;
            }).catch(function (resp) {
                alert("Не удалось загрузить компании");
            });
        }
    }
}
</script>