<template>
    <div class="content sm">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <br>
                    <h1 class="mb-30">
                        Administrar usuarios
                    </h1>
                    <br>
                    <div class="row mb-30" >
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-primary">
                                    <th class="text-white" scope="col">Nombre del usuario</th>
                                    <th class="text-white" scope="col">Correo electronico</th>
                                    <th class="text-white" scope="col">Posicion</th>
                                    <th class="text-white" scope="col">Perfil</th>
                                    <th class="text-white" scope="col">Número celular</th>
                                    <th class="text-white" scope="col">Ext.</th>
                                    <th class="text-white" scope="col">Matrícula</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>

                                </tr>
                            </thead>
                            <tbody v-for="user in users.data" :key="user.id">
                                <tr>
                                    <th scope="row">{{user.name}}</th>
                                    <td>{{user.email}}</td>
                                    <td>{{user.position}}</td>
                                    <td> 
                                        <p v-for="rol in user.roles" :key="rol.id">{{rol.name}}</p>
                                    </td>
                                    <td>{{user.phone}}</td>
                                    <td>{{user.extension}}</td>
                                    <td>{{user.enrollment}}</td>
                                    <td>
                                        <a href="#" :style="pointerYes">
                                            <img src="/img/ri-pencil-fill.svg">

                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" :style="pointerYes">
										    <img src="/img/ri-delete-bin-5-line.svg">

                                        </a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" id="pagination">
                <div class="col">
					<nav>
						<ul class="pagination">
							<li class="page-item mr-2" v-if="pagination.current_page > 1" >
								<a href="#" class="button-pagination page-link" @click.prevent="changePage(pagination.current_page - 1)">
									<span>Anterior</span>
								</a>
							</li>
							<li class="page-item mr-2" v-if="pagination.current_page == 1" >
								<a class="button-pagination page-link disabled">
									<span>Anterior</span>
								</a>
							</li>
							<li class="page-item mr-2" v-for="page in pagesNumber" :key="page">
								<a href="#" :class="[page == isActived ? 'active' : '']" class="button-pagination page-link" @click.prevent="changePage(page)">
								{{page}}
								</a>
							</li>
							<li class="page-item mr-2" v-if="pagination.current_page < pagination.last_page">
								<a href="#" class="button-pagination page-link" @click.prevent="changePage(pagination.current_page + 1)">
									<span>Siguiente</span>
								</a>
							</li>
							<li class="page-item mr-2" v-if="pagination.current_page == pagination.last_page" >
								<a class="button-pagination page-link disabled">
									<span>Siguiente</span>
								</a>
							</li>
						</ul>
					</nav>
				</div>
            </div>
        </div>
    </div>
    <div id="modalDeleteUser">

    </div>
    <div id="modalUpdateUser">

    </div>
</template>
<script>
export default {
    data() {
        return {
            users:[],
            roles:[],
            errors:[],
            user:{
                id:0,
                name:'',
                email:'',
                position:'',
                phone:'',
                extension:'',
                enrollment:'',
                user_rol:'',
            },
            invalid:{
                'name':0,
                'position':0,
                'email':0,
                'phone':0,
                'enrollment':0,
                'user_rol':0,
            },
            counterArrangements:1,
            pagination:{
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0,
            },
            offset: 2,
            pointerYes: {
                cursor: 'pointer',
            },
        };
    },
    methods: {
        getRoles(){
			axios.get('admin/list-roles').then(response=>{
				this.roles = response.data;
			})
		},
        getList(page = ''){
            const urlUsers = 'admin/list-users?page='+page;
            axios.get(urlUsers).then(response => {
                this.users = response.data.users;
                console.log(this.users);
                this.counterArrangements = this.users.data.length;
                this.pagination = response.data.pagination;
            });

        },
        changePage(page){
			this.pagination.current_page = page;
			this.getList(page);
		}
         
    },
    computed: {
        isActived() {
            return this.pagination.current_page;
        },
        pagesNumber() {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    mounted(){
        this.getList();
        this.getRoles();
    }
};
</script>
<style scoped>
.pagination{
		display: flex;
		justify-content:center !important;
	}
	.pagination .page-item .button-pagination {
		font-size: 18px;
		border: 0px solid #DFDFDF;
		display: inline-block;
		margin-bottom: 10px;
		text-decoration: none !important;
		transition: .3s all;
		border-radius: 4px;
		color: #03053D;
		text-align: center;
		padding: 10px 15px;
		cursor: pointer;
		background-color: #ffffff;
		margin-right: 15px;
	}
	.pagination .page-item .button-pagination:last-of-type{
		margin-right: 0px;
	}
	.pagination .page-item .button-pagination.disabled{
		color: #DFDFDF;
		cursor: not-allowed;
		background-color: #fff !important;
	}
	.pagination .page-item .button-pagination.active{
		background-color: #fff !important;
		box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.12);
	}
	.pagination .page-item .button-pagination:hover{
		background-color: #F6FAFE;
	}
</style>