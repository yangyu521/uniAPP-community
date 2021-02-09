<template>
	<view class="view-content-comment" v-if="commentList.length > 0">
		<text class="title">{{ title }}</text>
		<view class="view-pro-comment-list" v-for="(item, index) in commentList" :key="index">
			<view class="border-line" v-if="index > 0"></view>
			<view class="view-pro-comment-list-item">
				<image :src="item.HEADIMGURL" class="view-comment-list-item-photo" mode="aspectFill"></image>

				<view class="comment-pro-title" style="flex: 1;">
					<text class="comment-name">{{ item.FIRSTNICKNAME }}</text>
					<view class="tag-view" style="display: flex; "></view>
				</view>
				<!-- <view class="comment-pro-title" style="align-items: center;">
					<image
						v-if="item.IS_PRAISE == 1"
						class="praise-icon"
						mode="aspectFill"
					></image>
					<image
						v-else
						class="praise-icon"
						mode="aspectFill"
					></image>
					<text class="praise-num">{{ item.PRAISE_NUM }}</text>
				</view> -->
			</view>
			<text class="pro-comment-content">{{ item.COMMENT }}</text>
			<view class="pro-comment-sub">
				<text class="pro-comment-sub-time">{{ item.COMMENT_TIME }}</text>
				<!-- <text @click="clickDelete(item)" class="pro-comment-sub-time" style="padding-left: 20rpx;" v-if="item.CANDELETE == 1">删除</text> -->
			</view>
		</view>
	</view>
</template>

<script>
export default {
	name: 'CommentList',
	//属性
	props: {
		commentList: {
			type: Array,
			default: []
		},
		title: {
			type: String,
			default: '网友评论'
		}
	},
	data() {
		return {};
	},
	onLoad: function(e) {},
	onShow: function() {},
	methods: {
		/**
		 * 回复 评论
		 * @param {Object} item
		 */
		clickPraise(item) {
			this.$emit('clickPraise', item);
		},
		/**
		 * 删除评论
		 * @param {Object} item
		 */
		clickDelete(item) {
			this.$emit('clickDelete', item);
		}
	}
};
</script>
<style lang="scss">
@import '@/common/iconfont.css';
.view-content-comment {
	background-color: white;
	margin-top: 20rpx;
	display: flex;
	flex-direction: column;
	align-items: center;
	padding: 30rpx;
	.title {
		width: 100%;
		color: #333;
		font-weight: bold;
		font-size: 34rpx;
	}
}

.border-line {
	border-bottom: 1px solid #f6f6f6;
}
.view-pro-comment-list {
	width: 100%;
	display: flex;
	flex-direction: column;
	background-color: white;
	padding-bottom: 20rpx;
}
.view-pro-comment-list-item {
	display: flex;
	margin-top: 20rpx;
	flex: 1;
	flex-direction: row;
}
.comment-pro-title {
	justify-content: center;
	height: 90rpx;
	margin-left: 20rpx;
	display: flex;
	flex-direction: column;
}
.pro-comment-content {
	color: #000;
	font-size: 32rpx;
	font-weight: 500;
	margin-top: 20rpx;
}
.praise-icon {
	height: 46rpx;
	width: 46rpx;
	line-height: 1;
	font-size: 46rpx;
	color: #999;
}
.praise-num {
	font-size: 26rpx;
	color: #999;
}
.pro-comment-sub {
	display: flex;
	align-items: center;
	flex-direction: row;
	.pro-comment-sub-time {
		color: #999;
		font-size: 26rpx;
	}
}
.comment-name {
	color: #48648b;
	font-size: 32rpx;
	display: flex;
	align-items: center;
}

.view-comment-list-item-photo {
	height: 85rpx;
	width: 85rpx;
	border-radius: 5rpx;
	border: 1px solid #f6f6f6;
}
</style>
