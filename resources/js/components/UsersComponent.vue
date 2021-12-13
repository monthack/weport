<template>
    <div class="content sm">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <br>
                    <h1 class="mb-30">
                       Administración de usuarios
                    </h1>
                    <br>
                    <div class="row">
                        <div class="caja sm mb-15 especial">
                            <a href="#" class="button-circle main link" @click.prevent="openModalAdd()"><img src="/img/ri-add-line.svg" alt="" srcset=""></a> 
					    </div>
                    </div>
                    <div class="row mb-30" >
                        <table class="table table-hover" >
                            <thead style="border-radius: 25px;">
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
                                        <a href="#" :style="pointerYes" @click.prevent="openModalEdit(user)">
                                            <img src="/img/ri-pencil-fill.svg">

                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" :style="pointerYes" @click.prevent="openModalDestroy(user)">
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
    <!-- Modal -->
    <div class="modal" :class="{mostrar:modalDelete}" id="modalDeleteUser" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
        		<form>
                    <div class="modal-header">
                        <h4 class="modal-title">Eliminar usuario</h4>
                        <button type="button" @click="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
                    </div>
                    <div class="modal-body">
                        <h5 class="mb-0"><small>Vamos a eliminar al usuario <span class="font-weight-bold">“{{user_name}}”</span>. Este cambio no se puede deshacer ¿Estás seguro de que deseas hacerlo?</small></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click.prevent="deleteUser()">Eliminar</button>
                    </div>

        		</form>
            </div>
        </div>
    </div>
    <div class="modal" :class="{mostrar:modalUpdate}" id="modalUpdateUser" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="mb-0">{{title}}</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
						<span aria-hidden="true">×</span>
					</button>
				</div>	
				<form>
					<div class="modal-body">
							<div class="row mt-15">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="name">Nombre: *</label>
										<input type="text" name="name" id="name" class="form-control" :class="{'is-invalid':invalid.name}" required placeholder="Nombre completo" v-model="dataUser.name">
										<small class="form-text text-danger" :class="nameShowError" v-for="(e_name, index) in errors.name" :key="index">*{{e_name}}</small>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group ">
										<label for="email">Correo electrónico: *</label>
										<div class="form-control-icono">
											<input type="email" name="email" id="email" class="form-control" :class="{'is-invalid':invalid.email}" required placeholder="Correo electrónico" v-model="dataUser.email">                                		
											<i class="ri-mail-line"></i>
										</div>
										<small class="form-text text-danger" :class="emailShowError" v-for="(e_email, index) in errors.email" :key="index">*{{e_email}}</small>									
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="position">Cargo: *</label>
										<input type="text" name="position" id="position" class="form-control" :class="{'is-invalid':invalid.position}" required placeholder="Cargo" v-model="dataUser.position">
										<small class="form-text text-danger" :class="positionShowError" v-for="(e_position, index) in errors.position" :key="index">*{{e_position}}</small>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="user_rol">Perfil: *</label>
										<select  name="user_rol" id="user_rol" class="form-control" :class="{'is-invalid':invalid.user_rol}" v-model="dataUser.user_rol">
											<option disabled value="">Seleccione...</option>
											<option v-for="rol in roles" :key="rol.id" :value="rol.id">
												{{ rol.name }}
											</option>
										</select>
										<small class="form-text text-danger" :class="user_rolShowError" v-for="(e_user_rol, index) in errors.user_rol" :key="index">*{{e_user_rol}}</small>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group ">
										<label for="phone">Teléfono: *</label>
										<input type="tel" name="phone" id="phone" class="form-control" placeholder="00-0000-0000" :class="{'is-invalid':invalid.phone}" v-model="dataUser.phone">
										<small class="form-text text-danger" :class="phoneShowError" v-for="(e_phone, index) in errors.phone" :key="index">*{{e_phone}}</small>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="enrollment">Matricula: *</label>
										<input type="text" name="enrollment" id="enrollment" class="form-control" placeholder="Matricula" v-model="dataUser.enrollment">
										<small class="form-text text-danger" :class="enrollmentShowError" v-for="(e_enrollment, index) in errors.enrollment" :key="index">*{{e_enrollment}}</small>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="extension">Extensión: *</label>
										<input type="number" name="extension" id="extension" class="form-control" placeholder="Extension" v-model="dataUser.extension">
									</div>
								</div>	
								
							</div>	
					</div>	
					<div class="modal-footer" :class="{'text-right':createOrEditUser=='guardar'}">
						<button v-if="createOrEditUser=='guardar'" type="button" class="btn btn-secondary" data-dismiss="modal" @click="limpiar_campos()" >Cancelar</button>
						<button v-if="createOrEditUser=='editar'" type="button" class="btn btn-success float-right" @click.prevent="edit">Guardar ajustes</button>
						<button  v-if="createOrEditUser=='guardar'" type="button" class="btn btn-success float-right" @click.prevent="save">Añadir nuevo usuario</button>
					</div>
				</form>

			</div>
		</div>
    </div>
</template>
<script>
export default {
	
    data() {
        return {
            createOrEditUser:"guardar",
            title_message: '',
            title:'',
            alertUser:0,
            modalUpdate: 0,
            modalDelete: 0,
            user_id: '',
            user_name: '',
            users:[],
            roles:[],
            errors:[],
            dataUser:{
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
        limpiar_campos(){
			this.reiniciaMensajesError();
			this.title='';
			this.user_id='';
			this.user_name='';
			this.mostrar= 'mostrar';
            this.ocultar= 'ocultar';
			this.title_message =  '';
			this.dataUser.name='';
			this.dataUser.position='';
			this.dataUser.phone='';
			this.dataUser.extension='';
			this.dataUser.email='';
			this.dataUser.user_rol='';
			this.dataUser.enrollment='';
		},
		ocultarAlert(){
			this.alertUser = 1;
		},
		mostrarAlert(){
			this.alertUser = 1;
		},
        closeModal() {
            this.modalUpdate = 0;
            this.modalDelete = 0;
        },
		reiniciaMensajesError(){
			for(let inval in this.invalid) {
				this.invalid[inval] = 0;
			}
			this.invalid.name = 0;
		},
		mostrarErrores(){
			this.reiniciaMensajesError();
			for(let error in this.errors) {
				switch(error){
					case 'name':
						this.invalid.name = 1;
					break;
					case 'position':
						this.invalid.position = 1;
					break;
					case 'email':
						this.invalid.email = 1;
					break;
					case 'phone':
						this.invalid.phone = 1;
					break;
					case 'enrollment':
						this.invalid.enrollment = 1;
					break;
					case 'user_rol':
						this.invalid.user_rol = 1;
					break;
				}
			}
		},
		openModalAdd(){
			this.limpiar_campos();
			this.createOrEditUser = 'guardar';
			this.title = 'Agregar usuario';
			this.modalUpdate = 1;
		},
        save(){
			axios.post('admin/users-store', this.dataUser).then(response=>{
				this.modalUpdate = 0;
				if (response && response.data.statusCode == 200){
					this.title_message = 'Usuario agregado correctamente';
					//$("#alertUser").show();
					this.getUsers();
					//$("#alertUser").hide();
					
				}
				else{
					console.log(response);
				}
					this.limpiar_campos();
			}).catch((error)=> {
				if (error.response.status == 422) {
					this.errors = error.response.data.errors;
					this.mostrarErrores();
				}else{
					console.log(this.errors);
				}
			});
		},
        openModalEdit(data){
				this.createOrEditUser= 'editar';
                this.reiniciaMensajesError();
                this.dataUser= {
                    name: data.name,
                    position: data.position,
                    email: data.email,
                    phone: data.phone,
                    extension: data.extension,
					enrollment: data.enrollment,
                    user_rol: data.roles[0].id,
                    status:data.status,
                }
				this.title= 'Editar usuario';
                this.user_id = data.id;
				this.user_name = data.name;
                this.modalUpdate = 1;
        },
		edit(){
			axios.post('admin/users-validate/'+this.user_id,this.dataUser).then(response=>{
				if (response && response.data.statusCode == 200){
					this.modalUpdate = 0;
					this.title_message = "Editamos la información del usuario con éxito.";			
					//$("#alertUser").show();
						axios.post('admin/users-update/'+this.user_id, this.dataUser).then(response=>{
							 if (response && response.data.statusCode == 200){
								//$("#alertUser").hide();
								this.getUsers();
                    		}
                    		else{
                        		console.log(response);
                    		}
                     		this.limpiar_campos();
						}).catch(function (error) {
							console.log(error);
						});	
									
                }
                else{        
                    console.log(response);
                }
			}).catch((error)=> {
				if (error.response.status == 422) {
					this.errors = error.response.data.errors;
					this.mostrarErrores();
				}else{
					console.log(this.errors);
				}
			});
		},
        deleteUser(){
            this.closeModal()
			this.title_message = "Eliminamos al usuario con éxito.";
			//$("#alertUser").show();
			axios.post('admin/users-delete/'+this.user_id).then(response=>{
				this.getUsers();
				//$("#alertUser").hide();
			}).catch(function (error) {
				console.log(error);
			});

        },
        openModalDestroy(data){
            this.modalDelete = 1;
			this.user_id = data.id;
			this.user_name = data.name;
        },
        getRoles(){
			axios.get('admin/list-roles').then(response=>{
				this.roles = response.data;
			})
		},
        getUsers(page = ''){
            const urlUsers = 'admin/list-users?page='+page;
            axios.get(urlUsers).then(response => {
                this.users = response.data.users;
                this.counterArrangements = this.users.data.length;
                this.pagination = response.data.pagination;
            });

        },
        changePage(page){
			this.pagination.current_page = page;
			this.getUsers(page);
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
        },

        nameShowError(){
			return this.invalid.name ? this.mostrar : this.ocultar
		},
		positionShowError(){
			return this.invalid.position ? this.mostrar : this.ocultar
		},
		emailShowError(){
			return this.invalid.email ? this.mostrar : this.ocultar
		},
		phoneShowError(){
			return this.invalid.phone ? this.mostrar : this.ocultar
		},
		user_rolShowError(){
			return this.invalid.user_rol ? this.mostrar : this.ocultar
		},
		enrollmentShowError(){
			return this.invalid.enrollment ? this.mostrar : this.ocultar
		},
    },
    mounted(){
        this.getUsers();
        this.getRoles();
        //this.ocultarAlert();
    }
};
</script>
<style scoped>
    .ocultar{
        display: none;
    }
    .mostrar {
        display: list-item;
        opacity: 1;
    }
    .modal{
	background-color: rgba(0,0,0,0.7);
}
    .mb-15{
        margin-bottom: 15px;
    }
    .button-circle{
		font-size: 18px;
		border: 1px solid #DFDFDF;
		display: inline-block;
		margin-bottom: 10px;
		text-decoration: none !important;
		transition: .3s all;
		border-radius: 100%;
		color: #03053D;
		width: 35px;
		height: 35px;
		text-align: center;
		padding-top: 3px;
		cursor: pointer;
		background-color: #ffffff;
	}
		.button-circle:hover,
		.button-circle.hover{
			background-color: #F6FAFE;
			border: 1px solid #4A8EFF;
		}
		.button-circle:active,
		.button-circle.active{
			background: #03053D;
			border: 1px solid #03053D;
			color: #fff;
		}
		.button-circle.disabled{
			border: 1px solid #DFDFDF;
			color: #DFDFDF;
			cursor: not-allowed;
		}
		.button-circle.red{
			border: 1px solid #EB5757;
		}
		.button-circle.link{

			color: #4A8EFF;;
		}
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