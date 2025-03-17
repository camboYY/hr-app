<template>
    <div>
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-card-title>
                            <v-row>
                                <v-col cols="6">
                                    <h3 class="text-h5">Leave Setting List</h3>
                                </v-col>
                                <v-col cols="6" class="text-right">
                                    <v-btn
                                        color="primary"
                                        @click="
                                            () =>
                                                $router.push({
                                                    name: 'leaveSetting.create',
                                                })
                                        "
                                    >
                                        Add Leave Setting
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-title>

                        <v-card-text>
                            <v-data-table
                                v-model:items-per-page="leaveSettings.per_page"
                                :headers="headers"
                                :items="getDepartments"
                                :loading="loading"
                                item-key="id"
                                @update:page="fetchDepartmentAgain"
                                :items-length="departments.total"
                            >
                                <template v-slot:loading>
                                    <v-skeleton-loader
                                        type="table-row@10"
                                    ></v-skeleton-loader>
                                </template>

                                <template v-slot:item.actions="{ item }">
                                    <v-icon
                                        small
                                        class="mr-2"
                                        color="primary"
                                        @click="onEditDepartment(item)"
                                    >
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon
                                        small
                                        color="error"
                                        @click="
                                            onConfirmDeleteDepartment(item.id)
                                        "
                                    >
                                        mdi-delete
                                    </v-icon>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <ConfirmationDialog
                :dialog="dialog"
                title="Confirmation"
                message="Are you sure wanted to delete this item?"
                :onConfirm="onDeleteDepartment"
                :onCancel="() => (dialog = false)"
            />
        </v-container>
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
            { title: "Description", key: "description" },
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
        ...mapGetters("Department", ["departments"]),
        getDepartments() {
            return this.departments.data.map((item) => {
                return {
                    id: item.id,
                    name: item.name,
                    description: item.description,
                    created_at: moment(item.created_at).format(
                        "MMMM Do YYYY, h:mm:ss a"
                    ),
                };
            });
        },
    },
    async mounted() {
        await this.fetchDepartmentAgain();
    },
    methods: {
        ...mapActions("Department", [
            "fetchDepartments",
            "setDepartment",
            "deleteDepartment",
        ]),
        async fetchDepartmentAgain() {
            try {
                this.loading = true;
                await this.fetchDepartments();
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        },
        onEditDepartment(department) {
            this.setDepartment(department);
            this.$router.push({
                name: "department.edit",
                params: { id: department.id },
            });
        },
        onConfirmDeleteDepartment(id) {
            this.dialog = true;
            this.id = id;
        },

        async onDeleteDepartment() {
            this.dialog = false;
            await this.deleteDepartment(this.id);
        },
    },
};
</script>

<style lang="scss" scoped>
.title {
    color: #fff;
}
</style>
