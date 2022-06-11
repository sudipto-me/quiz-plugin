<?php
defined( 'ABSPATH' ) || exit;

class Quiz_Metabox {
	/**
	 * class constructor
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'qp_add_meta_box_quiz_quiz' ) );
		add_action( 'save_post', array( $this, 'qp_save_quiz_meta_box' ) );
	}
	
	/**
	 * Quiz Meta box functions
	 * @since 1.0.0
	 */
	public function qp_add_meta_box_quiz_quiz() {
        add_meta_box('qp-quiz-questions', __('Select Quiz Questions', 'quiz-questions'), array($this, 'qp_add_quiz_questions'), array('qp-quiz'));
		add_meta_box( 'qp-question-answers-1', __( 'Add Question First Answers', 'quiz-plugin' ), array( $this, 'qp_add_question_first_answers' ), array( 'qp-question' ) );
		add_meta_box( 'qp-question-answers-2', __( 'Add Question Second Answers', 'quiz-plugin' ), array( $this, 'qp_add_question_second_answers' ), array( 'qp-question' ) );
		add_meta_box( 'qp-question-answers-3', __( 'Add Question Third Answers', 'quiz-plugin' ), array( $this, 'qp_add_question_third_answers' ), array( 'qp-question' ) );
		add_meta_box( 'qp-question-answers-4', __( 'Add Question Forth Answers', 'quiz-plugin' ), array( $this, 'qp_add_question_forth_answers' ), array( 'qp-question' ) );
		add_meta_box( 'qp-question-correct-answer', __( 'Question Correct Answer', 'quiz-plugin' ), array( $this, 'qp_select_right_answer' ), array( 'qp-question' ) );
	}
    
    /**
     * Add quiz questions.
     *
     * @param \WP_Post $post Post_Object
     *
     * @since 1.0.0
    */
    public function qp_add_quiz_questions( $post ) {
        $value = get_post_meta( $post->ID, 'qp-quiz-questions', true );
        ?>
        <label for="quiz_questions">Select Quiz Questions</label>
        <?php
            $quiz_questions = get_posts( array('post_type' => 'qp-question', 'posts_per_page' => -1, 'post_status' => 'publish'));
        ?>
        <select name="quiz_questions[]" id="quiz_questions" class="select_quiz_questions" multiple>
            <?php
                if( is_array( $quiz_questions ) && count( $quiz_questions ) ) {
                    foreach ( $quiz_questions as $single ) {
                        $selected = !empty( $value ) && in_array( $single->ID, $value ) ? 'selected' : '';
                        echo '<option value="'.$single->ID.'"'.$selected.'>'.$single->post_title. '</option>';
                    }
                }else {
                    echo '<option value = "">No Questions Found'.'</option>';
                }
            ?>
        </select>
        <?php
    }
	
	/**
	 * Add question answers
	 *
	 * @param WP_POST $post Post object.
	 *
	 * @since 1.0.0
	 */
	public function qp_add_question_first_answers( $post ) {
		$value = get_post_meta( $post->ID, 'qp-question-answers-1', true );
		?>
        <label for="first_answer">first Question answers</label>
        <input type="text" name="first_answer" id="first_answer" value="<?php echo $value; ?>">
		<?php
	}
	
	/**
	 * Add question answers
	 *
	 * @param WP_POST $post Post object.
	 *
	 * @since 1.0.0
	 */
	public function qp_add_question_second_answers( $post ) {
		$value = get_post_meta( $post->ID, 'qp-question-answers-2', true );
		?>
        <label for="second_answer">Second Question answers</label>
        <input type="text" name="second_answer" id="second_answer" value="<?php echo $value; ?>">
		<?php
	}
	
	/**
	 * Add question answers
	 *
	 * @param WP_POST $post Post object.
	 *
	 * @since 1.0.0
	 */
	public function qp_add_question_third_answers( $post ) {
		$value = get_post_meta( $post->ID, 'qp-question-answers-3', true );
		?>
        <label for="third_answer">Third Question answers</label>
        <input type="text" name="third_answer" id="third_answer" value="<?php echo $value; ?>">
		<?php
	}
	
	/**
	 * Add question answers
	 *
	 * @param WP_POST $post Post object.
	 *
	 * @since 1.0.0
	 */
	public function qp_add_question_forth_answers( $post ) {
		$value = get_post_meta( $post->ID, 'qp-question-answers-4', true );
		?>
        <label for="forth_answer">Forth Question answers</label>
        <input type="text" name="forth_answer" id="forth_answer" value="<?php echo $value; ?>">
		<?php
	}
	
	/**
	 * Select question right answer
	 *
	 * @param WP_POST $post Post Object
	 *
	 * @since 1.0.0
	 */
	public function qp_select_right_answer( $post ) {
		$value = get_post_meta( $post->ID, 'qp-question-correct-answer', true );
		?>
        <label for="correct_answer">Select Correct Answer</label>
        <select name="correct_answer" id="correct_answer">
            <option value="qp-question-answers-1" <?php echo selected( $value, 'qp-question-answers-1' ); ?>><?php echo get_post_meta( $post->ID, 'qp-question-answers-1', true ); ?></option>
            <option value="qp-question-answers-2" <?php echo selected( $value, 'qp-question-answers-2' ); ?>><?php echo get_post_meta( $post->ID, 'qp-question-answers-2', true ); ?></option>
            <option value="qp-question-answers-3" <?php echo selected( $value, 'qp-question-answers-3' ); ?>><?php echo get_post_meta( $post->ID, 'qp-question-answers-3', true ); ?></option>
            <option value="qp-question-answers-4" <?php echo selected( $value, 'qp-question-answers-4' ); ?>><?php echo get_post_meta( $post->ID, 'qp-question-answers-4', true ); ?></option>
        </select>
		<?php
	}
    
    /**
     * Save quiz values.
     *
     * @param int $post_id Post ID.
     *
     * @since 1.0.0
    */
    public function qp_save_quiz_meta_box($post_id) {
     
	    if ( array_key_exists( 'first_answer', $_POST ) ) {
		    update_post_meta(
			    $post_id,
			    'qp-question-answers-1',
			    $_POST['first_answer']
		    );
	    }
	    if ( array_key_exists( 'second_answer', $_POST ) ) {
		    update_post_meta(
			    $post_id,
			    'qp-question-answers-2',
			    $_POST['second_answer']
		    );
	    }
	    if ( array_key_exists( 'third_answer', $_POST ) ) {
		    update_post_meta(
			    $post_id,
			    'qp-question-answers-3',
			    $_POST['third_answer']
		    );
	    }
	    if ( array_key_exists( 'forth_answer', $_POST ) ) {
		    update_post_meta(
			    $post_id,
			    'qp-question-answers-4',
			    $_POST['forth_answer']
		    );
	    }
	    if ( array_key_exists( 'correct_answer', $_POST ) ) {
		    update_post_meta(
			    $post_id,
			    'qp-question-correct-answer',
			    $_POST['correct_answer']
		    );
	    }
     
	    if ( array_key_exists( 'quiz_questions', $_POST ) ) {
		    update_post_meta(
			    $post_id,
			    'qp-quiz-questions',
			    $_POST['quiz_questions']
		    );
	    } else {
		    update_post_meta(
			    $post_id,
			    'qp-quiz-questions',
			    ''
		    );
	    }
    }
}

new Quiz_Metabox();
