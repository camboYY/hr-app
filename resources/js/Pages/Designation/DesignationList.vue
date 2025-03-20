<template>
    <div>
        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="6">
                        <h3 class="text-h5">Designation List</h3>
                    </v-col>
                    <v-col cols="6" class="text-right">
                        <v-btn
                            color="primary"
                            @click="
                                () =>
                                    $router.push({ name: 'designation.create' })
                            "
                        >
                            Add Designation
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :loading="loading"
                    :items="designation"
                    :items-per-page="designation.per_page"
                    :items-length="designation.total"
                    @update:page="fetchDesignationAgain"
                    v-model="designation.current_page"
                    item-key="id"
                    class="elevation-1"
                >
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            @click="onEditDesignation(item)"
                            class="mr-2"
                            color="primary"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            @click="onConfirmDeleteDesignation(item.id)"
                            color="error"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
        <confirmation-dialog
            :dialog="dialog"
            title="Confirmation"
            message="Are you sure wanted to delete this item?"
            :on-confirm="onDeleteDesignation"
            :on-cancel="onCancelDeleteDesignation"
        ></confirmation-dialog>
    </div>
</template>

<script>
import ConfirmationDialog from "@/components/ConfirmationDialog.vue";
import moment from "moment";
import { mapActions, mapGetters } from "vuex";

export default {
    data: () => ({
        loading: false,
        dialog: false,
        id: null,
        headers: [
            { title: "ID", key: "id" },
            { title: "Name", key: "name" },
            { title: "Responsibilities", key: "responsibilities" },
            { title: "Created At", key: "created_at" },
            {
                title: "Actions",
                key: "actions",
                sortable: false,
            },
        ],
    }),
    components: {
        ConfirmationDialog,
    },
    computed: {
        ...mapGetters("Designation", ["getDesignations"]),
        designation() {
            return this.getDesignations.data.map((item) => {
                return {
                    ...item,
                    created_at: this.format_date(item.created_at),
                };
            });
        },
    },
    async mounted() {
        await this.fetchDesignationAgain();
    },
    methods: {
        format_date(value) {
            if (value) {
                return moment(String(value)).format("MMMM Do YYYY, h:mm:ss a");
            }
        },
        ...mapActions("Designation", [
            "fetchDesignations",
            "setDesignation",
            "deleteDesignation",
        ]),
        async fetchDesignationAgain() {
            try {
                this.loading = true;
                await this.fetchDesignations();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        onEditDesignation(designation) {
            this.setDesignation(designation);
            this.$router.push({
                name: "designation.edit",
                params: { id: designation.id },
            });
        },
        onConfirmDeleteDesignation(id) {
            this.dialog = true;
            this.id = id;
        },
        async onDeleteDesignation() {
            try {
                this.loading = true;
                await this.deleteDesignation(this.id);
                this.dialog = false;
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        onCancelDeleteDesignation() {
            this.dialog = false;
        },
    },
};
</script>

<style lang="scss" scoped></style>
