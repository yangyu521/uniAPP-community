<template>
	<view>
		<view class="flex align-center p-2 border-bottom border-light-secondary" hover-class="bg-light">
			<image :src="item.avatar" mode="aspectFill" class="mr-2 rounded-circle" style="width: 100rpx;height: 100rpx;"></image>
			<view class="flex flex-column flex-1">
				<text>{{item.username}}</text>
				<uni-badge :text="item.age" :type="item.sex === 1 ? 'error' :'primary' " size="small" style="padding: 0 32rpx;">
					<template v-if="item.sex > 0">
						<text class="iconfont text-white font-sm" :class="item.sex === 1 ? 'icon-nv':'icon-nan'" style="margin-right: 5rpx;"></text>
					</template>
		
				</uni-badge>
			</view>
			<view class="uni-icon uni-icon-checkbox-filled" :class="item.isFellow ? 'text-light-muted' : 'text-main'"></view>
		</view>
	</view>
</template>

<script>
	import uniBadge from "@/components/uni-ui/uni-badge/uni-badge.vue"
	export default {
		components:{
			uniBadge
		},
		props:{
			item:Object,
			index:Number
		}
	}
</script>

<style>
</style>
