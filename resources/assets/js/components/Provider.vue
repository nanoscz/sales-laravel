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
          <i class="fa fa-align-justify"></i> Provider
          <button
            type="button"
            class="btn btn-secondary"
            @click="openModal('provider','register')"
          >
            <i class="icon-plus"></i>&nbsp;Add
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="option">
                  <option value="name">Name</option>
                  <option value="type_document">Document Type</option>
                  <option value="num_document">num_document</option>
                  <option value="direction">Direction</option>
                  <option value="phone">Phone</option>
                  <option value="email">email</option>
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
                <th>Document Type</th>
                <th>Document Number</th>
                <th>Direction</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Contact Phone</th>
                <!-- <th>State</th> -->
              </tr>
            </thead>
            <tbody>
              <tr v-for="provider in providers" :key="provider.id">
                <td>
                  <button
                    type="button"
                    class="btn btn-warning btn-sm"
                    @click="openModal('provider','update', provider)"
                  >
                    <i class="icon-pencil"></i>
                  </button> &nbsp;
                </td>
                <td v-text="provider.name"></td>
                <td v-text="provider.type_document"></td>
                <td v-text="provider.num_document"></td>
                <td v-text="provider.direction"></td>
                <td v-text="provider.phone"></td>
                <td v-text="provider.email"></td>
                <td v-text="provider.contact"></td>
                <td v-text="provider.contact_phone"></td>
                <!-- <td>
									<div v-if="provider.state">
                  	<span @click="changeState(provider.id)" class="badge badge-success">active</span>
									</div>
									<div v-else>
                  	<span @click="changeState(provider.id)" class="badge badge-danger">desactive</span>
									</div>
                </td>-->
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a
                  class="page-link"
                  href="#"
                  @click="changePage(pagination.current_page -1, search, option)"
                >Ant</a>
              </li>
              <li
                class="page-item"
                v-for="pag in pagesNumber"
                :key="pag"
                :class="[page = isActived ? 'active': '']"
              >
                <a class="page-link" href="#" v-text="pag" @click="changePage(pag, search, option)"></a>
              </li>
              <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                <a
                  class="page-link"
                  href="#"
                  @click="changePage(pagination.current_page + 1, search, option)"
                >Sig</a>
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
      :class="{'show': modal}"
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
                  <input type="text" v-model="name" class="form-control" placeholder="Name">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Document Type</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="type_document"
                    class="form-control"
                    placeholder="Document Type"
                  >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Number Document</label>
                <div class="col-md-9">
                  <input
                    type="number"
                    v-model="num_document"
                    class="form-control"
                    placeholder="Document Number"
                  >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Direction</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="direction"
                    class="form-control"
                    placeholder="Direction"
                  >
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Phone</label>
                <div class="col-md-9">
                  <input type="text" v-model="phone" class="form-control" placeholder="Phone">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                <div class="col-md-9">
                  <input type="email" v-model="email" class="form-control" placeholder="Email">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Contact</label>
                <div class="col-md-9">
                  <input type="text" v-model="contact" class="form-control" placeholder="contact">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Contact Phone</label>
                <div class="col-md-9">
                  <input
                    type="text"
                    v-model="contact_phone"
                    class="form-control"
                    placeholder="Contact Phone"
                  >
                </div>
              </div>
              <div v-show="err" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in listErr" :key="error" v-text="error"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
            <div v-if="typeAction == 1">
              <button type="button" class="btn btn-success" @click="save()">Save</button>
            </div>
            <div v-if="typeAction == 2">
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
      name: "",
      type_document: "",
      num_document: "",
      direction: "",
      phone: "",
      email: "",
      contact: "",
      contact_phone: "",
      providers: [],
      modal: 0,
      titleModal: "",
      typeAction: 0,
      err: 0,
      listErr: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      option: "name",
      search: ""
    };
  },
  computed: {
    isActived: function() {
      return;
    },
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      let to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      let pagesArray = [];
      while (from <= to) {
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
      let url =
        "/provider?page=" + page + "&search=" + search + "&option=" + option;
      axios
        .get(url)
        .then(function(res) {
          console.log(res);
          let response = res.data;
          ctrl.providers = response.providers.data;
          ctrl.pagination = response.pagination;
        })
        .catch(function(err) {
          console.error(err);
        });
    },
    changePage(page, search, option) {
      let ctrl = this;
      //update current page
      ctrl.pagination.current_page = page;
      //send request show data page
      ctrl.show(page, search, option);
    },
    validate() {
      this.clearError();
      if (!this.name) this.listErr.push("Field required name!");
      if (!this.type_document)
        this.listErr.push("Field required document type!");
      if (!this.num_document)
        this.listErr.push("Field required document number !");
      if (this.listErr.length) this.err = 1;
      return this.err;
    },
    save() {
      if (this.validate()) {
        return;
      }
      let ctrl = this;
      let data = {
        name: ctrl.name,
        type_document: ctrl.type_document,
        num_document: ctrl.num_document,
        direction: ctrl.direction,
        phone: ctrl.phone,
        email: ctrl.email,
        contact: ctrl.contact,
        contact_phone: ctrl.contact_phone
			};
			console.log({data});	
      axios
        .post("/provider", data)
        .then(function(res) {
          // me.providers.push(data)
          ctrl.show(1, "", "name");
          ctrl.closeModal();
          console.log(res);
        })
        .catch(function(err) {
          console.error("error al register", err);
        });
    },
    update() {
      if (this.validate()) {
        return;
      }
      let ctrl = this;
      let data = {
        id: ctrl.id,
        name: ctrl.name,
        type_document: ctrl.type_document,
        num_document: ctrl.num_document,
        direction: ctrl.direction,
        phone: ctrl.phone,
        email: ctrl.email,
        contact: ctrl.contact,
        contact_phone: ctrl.contact_phone
      };
      axios
        .put("/provider", data)
        .then(function(res) {
          ctrl.show(1, "", "name");
          ctrl.closeModal();
          console.log(res);
        })
        .catch(function(err) {
          console.error(err);
        });
    },
    openModal(model, action, data = []) {
      switch (model) {
        case "provider": {
          switch (action) {
            case "register": {
              this.clearError();
              this.modal = 1;
              this.typeAction = 1;
              this.titleModal = "Register Provider";
              this.name = "fernad";
              this.type_document = "CI";
              this.num_document = 123123;
              this.direction = "asdasd";
              this.phone = "123123";
              this.email = "asda@sadads.com";
              this.contact = "123123";
              this.contact_phone = "123123";
              break;
            }
            case "update": {
              this.modal = 1;
              this.typeAction = 2;
              this.titleModal = "Update Provider";
              this.id = data["id"];
              this.name = data["name"];
              this.type_document = data["type_document"];
              this.num_document = data["num_document"];
              this.direction = data["direction"];
              this.phone = data["phone"];
              this.email = data["email"];
              this.contact = data["contact"];
              this.contact_phone = data["contact_phone"];
            }
          }
        }
      }
    },
    closeModal() {
      this.modal = 0;
      this.titleModal = "";
      this.name = "";
      this.type_document = "";
      this.num_document = "";
      this.direction = "";
      this.phone = "";
			this.email = "";
			this.contact = "";
      this.contact_phone = "";
    },
    clearError() {
      this.err = 0;
      this.listErr = [];
    },
    changeState(id) {
      console.log("provider", id);
      let ctrl = this;
      let data = {
        id
      };
      const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false
      });

      swalWithBootstrapButtons
        .fire({
          title: "Change",
          text: "You want to change the state?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, change!",
          cancelButtonText: "No, cancel!",
          reverseButtons: true
        })
        .then(result => {
          if (result.value) {
            swalWithBootstrapButtons.fire(
              "Change!",
              "Change Sucessfull.",
              "success"
            );
            axios
              .put("/provider/state", data)
              .then(function(res) {
                ctrl.show(1, "", "name");
              })
              .catch(function(err) {
                console.error(err);
              });
          } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              "Cancelled",
              "Change Canceled.",
              "error"
            );
            console.log("B");
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
.show {
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