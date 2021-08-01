<template>
<div>
    <!-- staffs table -->
        <div class="card">
            <div class="card-header">
                    <div class="d-flex mb-3 justify-content-between">
                    <div>
                        <h3>Staff Area</h3>
                    </div>
                    <div>
                        <button class="btn btn-primary mr-2" @click="showAddStaffModal">Add new staff</button>
                        <a class="btn btn-danger float-right" target="__blank" href="/export-staffs/csv">Export csv</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="data-table_wrapper" class="dataTables_wrapper no-footer">
                    <table id="staffTable" class="table display table-hover text-center" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Date added</th>
                                <th scope="col">Date updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(staff, index) in staffs" v-bind:key="index" class="order-number-clickable">
                                <td>{{staff.name}}</td>
                                <td>{{staff.email_address}}</td>
                                <td>{{staff.role}}</td>
                                <td>{{ moment(staff.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                                <td>{{ moment(staff.updated_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end staff table-->
        <div class="modal fade p-4" id="addStaffModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md text-dark" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                        Add Staff
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" v-model="staffHolder.name" class="form-control" id="name"
                                placeholder="Type staff name">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" v-model="staffHolder.email" class="form-control" id="email"
                                placeholder="Type staff email">
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="number" v-model="staffHolder.phone_number" class="form-control" id="phonenumber"
                                placeholder="Type patient phone number">
                            </div>

                            <div class="form-group">
                                <label class="mr-2">Role</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" v-model="staffHolder.role" value="admin" type="radio" name="inlineRadioOptions" id="inlineRadio1">
                                        <label class="form-check-label" for="inlineRadio1">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" v-model="staffHolder.role" value="doctor" type="radio" name="inlineRadioOptions" id="inlineRadio2">
                                        <label class="form-check-label" for="inlineRadio2">Doctor</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" v-model="staffHolder.role" value="nurse" type="radio" name="inlineRadioOptions" id="inlineRadio2">
                                        <label class="form-check-label" for="inlineRadio2">Nurse</label>
                                    </div>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" :disabled="disableSubmitStaffButton" @click="submitStaff">Submit</button>
                    </div>
                    </div>
            </div>
        </div>
        <!-- end add patient modal -->
</div>

</template>

<script>
    export default {
        data() {
            return {
                staffs: [],
                staffHolder: {
                    name: '',
                    email: '',
                    phone_number: '',
                    role: ''
                }
            }
        },
        methods: {
            showAddStaffModal() {
                $("#addStaffModal").modal('show');
            },
            clearAddStaffModal() {
                this.staffHolder.name = '';
                this.staffHolder.email = '';
                this.staffHolder.phone_number = '';
                this.staffHolder.role = '';
            },
            submitStaff() {
                axios.post('/api/user?role=staff', this.staffHolder).then(response => {
                    if (response.status === 201) {
                        this.staffs.unshift(response.data);
                        this.resetDatatable();
                        this.clearAddStaffModal();
                        $("#addStaffModal").modal('hide');

                        return this.$toast.open(`Staff added successfully`);
                    }

                    return this.$toast.open({
                        message: `Error, please try again.`,
                        type: 'error',
                    });
                }).catch(error => {
                    return this.$toast.open({
                        message: `Error, please try again.`,
                        type: 'error',
                    });
                }).finally(() => {
                })
            },
            resetDatatable() {
                $('#staffTable').DataTable().destroy();

                setTimeout(function() {
                    $('#staffTable').DataTable({
                        "order": false,
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                    });
                });
            },
            moment(date) {
                return moment(date);
            },
            getStaffs () {
                axios.get('/api/user/?role=staff').then(response => {
                    this.staffs = response.data;
                }).catch(error => {
                    console.log('error', error);
                }).finally(() => {
                     $('#staffTable').DataTable({
                        "ordering": false,
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                    });
                })
            },
        },
        created() {
            this.getStaffs();
        },
        computed: {
            disableSubmitStaffButton() {
                return false;
            }
        }
    }
</script>
