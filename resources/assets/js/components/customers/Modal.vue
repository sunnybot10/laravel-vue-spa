        <!--start of modal-->
        <div class="modal" id="addNew">
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Customer's Info</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form @submit.prevent="editmode ? updateCustomer() : createCustomer()">
                <div class="modal-body">
                  <div class="input-group mb-3">
                        <input type="text" 
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('name') }"
                            v-model="form.name"
                            name="name" 
                            placeholder="Full name">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-user"></span>
                          </div>
                        </div>
                        <has-error :form="form" field="name">
                        </has-error>
                      </div>

                  <div class="input-group mb-3">
                        <input type="text" 
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('email') }"
                            v-model="form.email"
                            name="email" 
                            placeholder="Email">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                          </div>
                        </div>
                        <has-error :form="form" field="email">
                        </has-error>
                      </div>
                  <div class="input-group mb-3">
                        <input type="text" 
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('phone') }"
                            v-model="form.phone"
                            name="phone" 
                            placeholder="phone">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                          </div>
                        </div>
                        <has-error :form="form" field="phone">
                        </has-error>
                      </div>
                      <div class="input-group mb-3">
                        <input type="text" 
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('address') }"
                            v-model="form.address"
                            name="address" 
                            placeholder="address">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fa fa-map-marker"></span>
                          </div>
                        </div>
                        <has-error :form="form" field="address">
                        </has-error>
                      </div>
                      <div class="input-group mb-3">
                        <input type="text" 
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('birthday') }"
                            v-model="form.birthday"
                            name="birthday" 
                            placeholder="birthday">
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fa fa-calendar-alt"></span>
                          </div>
                        </div>
                        <has-error :form="form" field="birthday">
                        </has-error>
                      </div>
                </div>
                <div class="modal-footer">
                  <button v-show="editmode" type="submit" class="btn btn-success mr-auto">Update
                  </button>
                  <button v-show="!editmode" type="submit" class="btn btn-success mr-auto">Create
                  </button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!--end of modal-->