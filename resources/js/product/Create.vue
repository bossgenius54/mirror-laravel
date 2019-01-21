<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
    
        <div class="panel panel-default">
            <div class="panel-heading">Create new company</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company name</label>
                            <input type="text" v-model="company.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company note</label>
                            <input type="text" v-model="company.note" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Company color</label>
                            <input type="text" v-model="company.color" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
export default {
    data: function () {
        return {
            company: {
                name: '',
                address: '',
                website: '',
                email: '',
            }
        }
    },
    methods: {
        saveForm() {
            event.preventDefault();
            var app = this;
            var newCompany = app.company;

            axios.put('/json/project/create', newCompany).then(function (resp) {
                app.$router.push({path: '/'});
            }).catch(function (resp) {
                console.log(resp);
                alert("Не удалось создать компанию");
            });
        }
    }
}
</script>