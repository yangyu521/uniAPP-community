<template>
	<view>
		<uni-collapse>
			<uni-collapse-item title="程序帮助" showAnimation>
				<text class="content p-2">欢迎来到由杨雨同志开发的uni-app社区交友，本程序可以支持一端开发，多端使用。可以发送朋友圈，开以实现通讯。前后端交互效果佳</text>
			</uni-collapse-item>
			<uni-collapse-item title="遇到BUG或使用故障,应如何排查和快速反馈" showAnimation>
				<text class="content p-2">1.检查客户端是否为最新版本：应用商店更新最新版本客户端，可解决版本较低带来的使用故障。</br>2.排查当前网络状况是否良好：运行其他应用是否也存在类似故障，建议退出客户端清除进程，重新登录。</text>
			</uni-collapse-item>
		</uni-collapse>
		
		<view class="py-2 px-3">
			<button class="bg-main text-white" style="border-radius: 50rpx;border: 0;" type="primary">意见反馈</button>
		</view>
	</view>
</template>

<script>
	import uniCollapseItem from "@/components/uni-ui/uni-collapse-item/uni-collapse-item.vue"
	import uniCollapse from "@/components/uni-ui/uni-collapse/uni-collapse.vue"
	export default {
		components:{
			uniCollapseItem,
			uniCollapse
		},
		data() {
			return {
				
			}
		},
		methods: {
			
		}
	}
</script>

<style>

</style>
