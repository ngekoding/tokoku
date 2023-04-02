<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import {
    mdiArrowLeft,
    mdiClose,
    mdiPackageVariantClosed
} from '@mdi/js';
import { pick } from 'lodash';
import { formatCurrency } from '@/utils';
import BaseButton from '@/Components/BaseButton.vue';
import BaseIcon from '@/Components/BaseIcon.vue';
import TextInput from '@/Components/TextInput.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Alert from '@/Components/Alert.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

defineOptions({ layout: DefaultLayout });

defineProps({
    items: {
        type: Object,
        default: () => ([])
    },
    customers: {
        type: Object,
        default: () => ([])
    }
});

const form = useForm({
    customer: '',
    items: [],
    date: '',
    address: '',
});

const itemTmp = ref('')

const addItem = () => {
    if (itemTmp.value) {
        const indexExists = form.items.findIndex(item => item.id === itemTmp.value.id);
        if (indexExists != -1) {
            form.items[indexExists].qty++;
        } else {
            form.items.push({
                ...itemTmp.value,
                qty: 1,
                discount: 0,
                note: '',
            });
        }

        // Reset itemTmp
        itemTmp.value = '';
    }
}

const removeItem = (index) => {
    form.items.splice(index, 1);
}

const useCustomerAddress = () => {
    if (form.customer) {
        form.address = form.customer.address;
    }
}

const subTotal = computed(() => {
    return form.items.reduce((total, item) => +item.price * item.qty + total, 0);
})

const discountTotal = computed(() => {
    return form.items.reduce((total, item) => +item.discount + total, 0);
})

const finalTotal = computed(() => subTotal.value - discountTotal.value);

const submit = () => {
    form.transform(data => ({
            ...data,
            customer: data.customer.id,
            items: data.items.map(item => pick(item, ['id', 'qty', 'discount', 'note']))
        }))
        .post(route('transactions.create'), {
            onSuccess: () => form.reset(),
        });
}
</script>

<template>
    <Head title="Add Transaction" />

    <BaseButton
        with-icon
        @click="router.get(route('transactions'))"
        class="mx-4 sm:mx-0"
    >
        <BaseIcon :path="mdiArrowLeft" class="mr-1" /> Back
    </BaseButton>

    <Alert
        v-if="form.recentlySuccessful"
        type="success"
        class="mb-4"
        flash
    >
        <span class="font-medium">Success!</span> The transaction successfully added.
    </Alert>

    <div class="mt-2 w-full flex flex-col md:flex-row items-start gap-2">
        <div class="w-full md:basis-2/3 flex flex-col space-y-2">
            <div class="bg-white shadow-sm overflow-hidden sm:rounded-lg">
                <div class="p-4">
                    <h2 class="font-medium uppercase text-sm tracking-widest text-gray-700 pb-2 border-b border-gray-100">Items</h2>
                    <div class="mt-4 space-y-4 divide-y divide-gray-100 divide-dashed">
                        <div
                            v-for="(item, i) in form.items"
                            :key="'added-item-' + i"
                            class="flex items-start space-x-2 pt-2 first:pt-0"
                        >
                            <div class="flex-grow">
                                <h3 class="text-gray-500">{{ item.name }}</h3>
                                <div class="text-gray-800 font-medium leading-none">{{ formatCurrency(item.price) }}</div>
                                <div class="mt-2 flex items-center flex-wrap gap-1.5">
                                    <div class="inline-flex flex-row">
                                        <div class="text-sm text-center px-2 py-1 border border-transparent bg-gray-100 rounded-l-md">Qty</div>
                                        <input
                                            v-model="item.qty"
                                            type="number"
                                            min="1"
                                            class="text-sm text-center border border-gray-100 rounded-r-md pl-2 pr-0 py-1 w-[50px]"
                                        />
                                    </div>
                                    <div class="inline-flex flex-row">
                                        <div class="text-sm text-center px-2 py-1 border border-transparent bg-gray-100 rounded-l-md">Discount (Rp)</div>
                                        <input
                                            v-model="item.discount"
                                            type="number"
                                            min="0"
                                            :max="item.price"
                                            class="text-sm text-center border border-gray-100 rounded-r-md pl-2 pr-0 py-1 w-[100px]"
                                        />
                                    </div>
                                    <div class="inline-flex flex-row">
                                        <div class="text-sm text-center px-2 py-1 border border-transparent bg-gray-100 rounded-l-md">Note</div>
                                        <input
                                            v-model="item.note"
                                            type="text"
                                            class="text-sm border border-gray-100 rounded-r-md px-2 py-1 w-[170px]"
                                            placeholder="Write a note..."
                                        />
                                    </div>
                                </div>
                            </div>
                            <BaseButton
                                icon-only
                                class="flex-shrink-0"
                                @click="removeItem(i)"
                            >
                                <BaseIcon :path="mdiClose" />
                            </BaseButton>
                        </div>
                    </div>
                </div>
                <!-- Empty Item -->
                <div v-if="!form.items.length" class="flex flex-col justify-center items-center pt-4 pb-10">
                    <BaseIcon
                        :path="mdiPackageVariantClosed"
                        w="w-[70px]"
                        h="h-[70px]"
                        size="70"
                        class="text-gray-300"
                    />
                    <div class="text-gray-400">No item added.</div>
                </div>
                <InputError class="my-2 mx-4" :message="form.errors.items" />
                <div class="bg-gray-50 p-4 flex space-x-1">
                    <select v-model="itemTmp" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-1.5">
                        <option value="">Choose an item</option>
                        <option
                            v-for="item in items"
                            :key="item.id"
                            :value="item"
                        >
                            {{ item.name }} - {{ formatCurrency(item.price) }}
                        </option>
                    </select>
                    <BaseButton
                        type="success"
                        class="flex-shrink-0"
                        @click="addItem()"
                    >
                        Add item
                    </BaseButton>
                </div>
            </div>
            <div class="bg-white p-4 shadow-sm sm:rounded-lg">
                <h2 class="font-medium uppercase text-sm tracking-widest text-gray-700 pb-2 border-b border-gray-100">Customer Information</h2>
                <select v-model="form.customer" class="mt-4 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-1.5">
                    <option value="">Choose a customer</option>
                    <option
                        v-for="customer in customers"
                        :key="customer.id"
                        :value="customer"
                    >
                        {{ customer.name }}
                    </option>
                </select>
                <div v-if="form.customer" class="mt-4 space-y-3">
                    <div>
                        <div class="text-sm text-gray-500">Name</div>
                        <div class="text-gray-800 font-medium">{{ form.customer.name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Phone</div>
                        <div class="text-gray-800 font-medium">{{ form.customer.phone }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Address</div>
                        <div class="text-gray-800 font-medium">{{ form.customer.address }}</div>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.customer" />
            </div>
        </div>
        <div class="w-full md:basis-1/3 flex flex-col space-y-2">
            <div class="bg-white p-4 shadow-sm sm:rounded-lg">
                <h2 class="font-medium uppercase text-sm tracking-widest text-gray-700 pb-2 border-b border-gray-100">Additionals</h2>
                <div class="mt-2">
                    <InputLabel for="date" value="Date" />
                    <TextInput
                        id="date"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.date"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.date" />
                </div>
                <div class="mt-4">
                    <InputLabel for="address" value="Address" />
                    <TextInput
                        id="address"
                        type="textarea"
                        class="mt-1 block w-full"
                        v-model="form.address"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.address" />
                    <button class="text-blue-500 text-sm py-2 hover:text-blue-600" @click="useCustomerAddress()">
                        Use customer address
                    </button>
                </div>
            </div>
            <div class="bg-white p-4 shadow-sm sm:rounded-lg">
                <h2 class="font-medium uppercase text-sm tracking-widest text-gray-700 pb-2 border-b border-gray-100">Payment Details</h2>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <div class="text-gray-700 font-medium text-sm">Sub-total</div>
                        <div class="text-gray-600 text-sm">{{ formatCurrency(subTotal) }}</div>
                    </div>
                    <div class="flex justify-between">
                        <div class="text-gray-700 font-medium text-sm">Discount</div>
                        <div class="text-gray-600 text-sm">-{{ formatCurrency(discountTotal) }}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-gray-900 font-semibold text-sm">Total</div>
                        <div class="text-gray-900 font-semibold text-lg">{{ formatCurrency(finalTotal) }}</div>
                    </div>
                </div>
                <BaseButton
                    type="success"
                    class="mt-4 w-full"
                    @click="submit()"
                >
                    Save Transaction
                </BaseButton>
            </div>
        </div>
    </div>
</template>
