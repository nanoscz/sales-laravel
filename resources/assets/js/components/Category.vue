<template>
  <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item">
        <a href="#">Admin</a>
      </li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Category
          <button
            type="button"
            class="btn btn-secondary"
						@click="openModal('category','register')">
            <i class="icon-plus"></i>&nbsp;Add
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="option">
                  <option value="name">Name</option>
                  <option value="description">Description</option>
                </select>
                <input
                  type="text"
                  v-model="search"
                  class="form-control"
									@keyup.enter="show(1,search, option)"
                  placeholder="Seach..."
                >
                <button type="submit" class="btn btn-primary" @click="show(1, search, option)">
                  <i class="fa fa-search"></i> Search
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="category in categories" :key="category.id">
                <td>
                  <button
                    type="button"
                    class="btn btn-warning btn-sm"
										@click="openModal('category','update', category)">
                    <i class="icon-pencil"></i>
                  </button> &nbsp;
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
										@click="openModal('category','register')"
										>
                    <i class="icon-trash"></i>
                  </button>
                </td>
                <td v-text="category.name"></td>
                <td v-text="category.description"></td>
                <td>
									<div v-if="category.state">
                  	<span @click="changeState(category.id)" class="badge badge-success">active</span>
									</div>
									<div v-else>
                  	<span @click="changeState(category.id)" class="badge badge-danger">desactive</span>
									</div>
                </td>
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a class="page-link" href="#" @click="changePage(pagination.current_page -1, search, option)">Ant</a>
              </li>
              <li class="page-item" v-for="pag in pagesNumber" :key="pag" 
								:class="[page = isActived ? 'active': '']">
                <a class="page-link" href="#" v-text="pag" @click="changePage(pag, search, option)"></a>
              </li>
              <li class="page-item"  v-if="pagination.current_page < pagination.last_page">
                <a class="page-link" href="#" @click="changePage(pagination.current_page + 1, search, option)">Sig</a>
               </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
			:class="{'show-modal': modal}"
			>
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="titleModal"></h4>
            <button type="button" class="close" aria-label="Close" @click="closeModal()">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Name</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="name"
                    class="form-control"
                    placeholder="Name"
                  >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Description</label>
                <div class="col-md-9">
                  <input
                    type="email"
										v-model="description"
                    class="form-control"
                    placeholder="Description"
                  >
                </div>
              </div>
							 <div v-show="err" class="form-group row div-error">
								 <div class="text-center text-error">
									 <div v-for="error in listErr" :key="error" v-text="error">
									 </div>
								 </div>
							 </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
            <div v-if="typeAction == 1">
							<button type="button" class="btn btn-success" @click="save()">Save</button>
						</div>
						<div  v-if="typeAction == 2">
							<button type="button" class="btn btn-primary" @click="update()">Update</button>
						</div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    <!-- Inicio del modal Eliminar -->
    <div
      class="modal fade"
      id="modalEliminar"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar Categoría</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Estas seguro de eliminar la categoría?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-danger">Eliminar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Eliminar -->
  </main>
</template>

<script>
export default {
  data() {
    return {
			id: 0,
      name: '',
      description: '',
			categories: [],
			modal: 0,
			titleModal: '',
			typeAction: 0,
			err: 0,
			listErr: [],
			pagination: {
				total: 0,
				current_page: 0,
				per_page: 0,
				last_page: 0,
				from: 0,
				to:0
			},
			offset: 3,
			option:'name',
			search:''
    };
	},
	computed: {
		isActived: function () {
			return 
		},
		pagesNumber: function() {
			if (!this.pagination.to) {
				return []
			}

			let from = this.pagination.current_page - this.offset;
			if (from < 1) {
				from = 1;
			}

			let to = from + (this.offset * 2);
			if (to >= this.pagination.last_page) {
				to = this.pagination.last_page;
			}

			let pagesArray= [];
			while(from <= to){
				pagesArray.push(from);
				from++;
			}
			return pagesArray;
		}
	},
  methods: {
    show(page, search, option) {
			console.log(page);
			let ctrl = this;
			let url = '/category?page=' + page + '&search=' + search + '&option=' + option;
      axios
        .get(url)
        .then(function(res) {
					console.log(res);
					let response = res.data;
					ctrl.categories = response.categories.data;
					ctrl.pagination = response.pagination;
        })
        .catch(function(err) {
          console.error(err);
        });
		},
		changePage(page, search, option){
			let ctrl = this;
			//update current page
			ctrl.pagination.current_page = page;
			//send request show data page
			ctrl.show(page, search, option);
		},
		validate(){
			this.clearError();
			if (!this.name) this.listErr.push('Field required name!')
			if (this.listErr.length) this.err = 1
			return this.err;
		},
		save() {
			if (this.validate()) {
				return; 
			}
			let ctrl = this;
			let data = {
				'name': ctrl.name,
				'description': ctrl.description 
			};
      axios
        .post("/category", data)
        .then(function(res) {
					// me.categories.push(data)
					ctrl.show(1, '', 'name');
					ctrl.closeModal();
					console.log(res);
        })
        .catch(function(err) {
          console.error('error al register', err);
        });
		},
		update() {
			if (this.validate()) {
				return; 
			}
			let ctrl = this;
			let data = {
				'id': ctrl.id,
				'name': ctrl.name,
				'description': ctrl.description 
			};
      axios
        .put("/category", data)
        .then(function(res) {
					ctrl.show(1, '', 'name');
					ctrl.closeModal();
          console.log(res);
        })
        .catch(function(err) {
          console.error(err);
        });
		},
		openModal(model, action, data = []) {
			switch (model) {
				case "category":
				{
					switch (action) {
						case "register":
						{
							this.clearError();
							this.modal = 1;
							this.typeAction = 1;
							this.titleModal = 'Register Category'
							this.name= '';
							this.description = '';
							break;
						}
						case "update":
						{
							this.modal = 1;
							this.typeAction = 2;
							this.titleModal = 'Update Category';
							this.id = data['id'];
							this.name = data['name'];
							this.description = data['description'];
						}
					}
				}
			}
		},
		closeModal() {
			this.modal = 0;
			this.titleModal = '';
			this.name= '';
			this.description = '';
		},
		clearError(){
			this.err = 0;
			this.listErr = [];
		},
		changeState(id) {
			console.log('category',id);
			let ctrl = this;
			let data = {
				id
			};
			const swalWithBootstrapButtons = Swal.mixin({
				confirmButtonClass: 'btn btn-success',
				cancelButtonClass: 'btn btn-danger',
				buttonsStyling: false,
			})

			swalWithBootstrapButtons.fire({
				title: 'Change',
				text: "You want to change the state?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, change!',
				cancelButtonText: 'No, cancel!',
				reverseButtons: true
			}).then((result) => {
				if (result.value) {
					swalWithBootstrapButtons.fire(
						'Change!',
						'Change Sucessfull.',
						'success'
					)
					axios
						.put("/category/state", data)
						.then(function(res) {
							ctrl.show(1, '', 'name');
						})
						.catch(function(err) {
							console.error(err);
						});
				} else if (
					// Read more about handling dismissals
					result.dismiss === Swal.DismissReason.cancel
				) {
					swalWithBootstrapButtons.fire(
						'Cancelled',
						'Change Canceled.',
						'error'
					)
						console.log('B')
				}
			});
		}
  },
  mounted() {
    this.show(1, this.search, this.option);
  }
};
</script>
<style>
	.modal-content {
		width: 100% !important;
		position: absolute !important;
	}
	.show-modal {
		display: list-item !important;
		opacity: 1 !important;
		position: absolute !important;
		background-color: #3c29297a !important;
	}
	.div-error {
		display: flex;
		justify-content: center;
	}
	.text-error {
		color: red !important;
		font-weight: bold;
	}
</style>