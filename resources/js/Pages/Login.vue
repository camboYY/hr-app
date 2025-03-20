<template>
    <div>
        <v-card elevation="2">
            <v-form v-model="valid">
                <v-container fluid class="content">
                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="email"
                            :counter="10"
                            label="E-mail"
                            required
                        ></v-text-field>
                        <div :class="{ error: v$.email.$errors.length }">
                            <div
                                class="input-errors"
                                v-for="error of v$.email.$errors"
                                :key="error.$uid"
                            >
                                <div class="text-error">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-text-field
                            v-model="password"
                            :counter="10"
                            label="Password"
                            required
                            type="password"
                        ></v-text-field>
                        <div :class="{ error: v$.password.$errors.length }">
                            <div
                                class="input-errors"
                                v-for="error of v$.password.$errors"
                                :key="error.$uid"
                            >
                                <div class="text-error">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div>
                    </v-col>
                    <v-btn
                        @click="login"
                        :loading="loading"
                        color="primary"
                        class="text-center btn"
                        :disabled="loading"
                    >
                        Login
                    </v-btn>
                </v-container>
            </v-form>
        </v-card>
    </div>
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import { email, minLength, required } from "@vuelidate/validators";
import { useRouter } from "vue-router";
import { mapActions, useStore } from "vuex";

export default {
    setup() {
        const router = useRouter();
        const store = useStore();
        const v$ = useVuelidate();
        return { v$, store, router };
    },

    data: () => ({
        loading: false,
        email: "",
        password: "",
    }),
    validations() {
        return {
            email: { required, email },
            password: { required, atLeast: minLength(5) },
        };
    },
    methods: {
        ...mapActions("Auth", ["userLogin"]),
        async login() {
            const result = await this.v$.$validate();
            if (!result) {
                // notify user form is invalid
                return;
            }
            try {
                this.loading = true;

                await this.userLogin({
                    email: this.email,
                    password: this.password,
                });
                this.router.push({ name: "about" });
            } catch (e) {
                console.log(e);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.content {
    display: flex;
    justify-self: center;
    align-items: center;
    flex-direction: column;
    .btn {
        padding: 10px 20px;
        height: 45px;
        cursor: pointer;
    }
}
</style>
