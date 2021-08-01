<template>
<div>
    <div class="row">
        <div class="offset-sm-6 col-sm-6">
            <button class="btn btn-primary mr-2 float-right" @click="showAddObservationModal">Add observation</button>
            <a class="btn btn-danger float-right mr-2" target="__blank" href="/export-observation/csv" v-show="user.observations.length > 0">Export csv</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-5">
            <!-- single patient info -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">
                                    Patient Information
                                </h5>
                            </div>
                            <div>
                                Added on {{moment(user.created_at).format('MMMM Do YYYY, h:mm:ss a')}}
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <p>Name: {{user.name}}</p>
                        <p>Email address: {{user.email_address}}</p>
                        <p>Phone number: {{user.phone_number}}</p>
                    </div>
                </div>
            <!--end single patient info-->

        </div>
        <div class="col-sm-7">
            <!-- single patient observations info -->
            <div v-if="user.observations.length > 0">
                <div class="card" v-for="observation in user.observations" v-bind:key="observation.id">
                    <div class="card-header">
                            <h5 class="card-title">Observation carried out on {{moment(user.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</h5>
                    </div>
                    <div class="card-body">
                        <p>Reading (mmHg): {{observation.reading}}</p>
                        <p>Notes: {{observation.notes}}</p>
                    </div>
                </div>
            </div>
            <div v-else>
                No observations for patient.
            </div>
            <!--end single patient observations info-->

        </div>
            <!-- add observation modal -->
            <div class="modal fade p-4" id="addObservationModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md text-dark" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                            Add observation for patient
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label>Reading</label>
                                    <input type="text" v-model="observation.reading" class="form-control" id="name"
                                    placeholder="Type patient name">
                                </div>

                                <div class="form-group">
                                    <label>Notes</label>
                                    <input type="text" v-model="observation.notes" class="form-control" id="email"
                                    placeholder="Type patient email">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" :disabled="disableSubmitPatientButton" @click="submitObservation">Submit</button>
                        </div>
                        </div>
                    </div>
            </div>
            <!-- end add observation modal -->
    </div>
</div>

</template>

<script>
    export default {
        data() {
            return {
                user: {},
                observation: {
                    user_id: this.userid,
                    notes: '',
                    reading: ''
                }
            }
        },
        props: {
            userid: Number
        },
        methods: {
            submitObservation() {
                axios.post('/api/observation', this.observation).then(response => {
                    if (response.status === 201) {
                        this.user.observations.unshift(response.data);
                        this.clearAddObservationModal();

                        $("#addObservationModal").modal('hide');

                        return this.$toast.open(`Observation added successfully`);
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
                })
            },
            showAddObservationModal() {
                $('#addObservationModal').modal('show');
            },
            exportPatientObservationAsCSv() {
                axios.get(`/api/user/${this.user.id}/observation/?type=csv`).then(response => {
                    console.log(response.data);
                }).catch(error => {
                    console.log(error);
                })
            },
            clearAddObservationModal() {
                this.observation.notes = '';
                this.observation.reading = '';
            },
            moment(date) {
                return moment(date);
            },
            getUser () {
                axios.get(`/api/user/${this.userid}`).then(response => {
                    this.user = response.data;
                }).catch(error => {
                    console.log('error', error);
                }).finally(() => {

                })
            },
        },
        created() {
            this.getUser();
        },
        computed: {
            disableSubmitPatientButton() {
                return false;
            }
        }
    }
</script>
